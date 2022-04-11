<?php

namespace App\Fund;

use App\Auth\Database\UserTable;
use App\Auth\DatabaseUserAuth;
use App\Fund\Database\TransferTable;
use ClientX\Actions\Traits\AuthTrait;
use ClientX\Actions\Traits\ContainerTrait;
use ClientX\Actions\Traits\FlashTrait;
use ClientX\Session\FlashService;
use ClientX\Session\SessionInterface;
use ClientX\Validator;
use Psr\Container\ContainerInterface;

class FundService
{
    private UserTable $userTable;
    /**
     * @var \ClientX\Session\SessionInterface
     */
    private SessionInterface $session;
    /**
     * @var \App\Fund\Database\TransferTable
     */
    private TransferTable $transferTable;
    use FlashTrait;
    use ContainerTrait;
    use AuthTrait;

    public function __construct(
        UserTable $userTable,
        TransferTable $transferTable,
        SessionInterface $session,
        FlashService $flash,
        ContainerInterface $container,
        DatabaseUserAuth $auth
    ) {
        $this->userTable = $userTable;
        $this->flash = $flash;
        $this->container = $container;
        $this->session = $session;
        $this->transferTable = $transferTable;
        $this->auth = $auth;
    }

    public function add(string $email, float $amount)
    {
        $userId = $this->getUserId();
        $recipientId = $this->userTable->findBy("email", $email)->getId();
        /** @var \App\Account\User $user */
        $user = $this->getUser();
        $user->removeFund($amount);
        $this->userTable->updateWallet($user);
        $this->transferTable->addTransfer($userId, $recipientId, $amount);
    }

    public function validate(array $params)
    {
        return (new Validator($params))
            ->min((int)$this->get('fundconfig.mintransfer'), 'amount')
            ->max((int)$this->get('fundconfig.maxtransfer'), 'amount')
            ->notEmpty('email')
            ->notInArray('email', [$this->getUser()->getEmail()])
            ->max($this->getUser()->getWallet(), 'amount')
            ->exists('email', $this->userTable);
    }

    public function saveErrors(array $errors)
    {
        $this->session->set('fund_errors', $errors);
    }

    public function findForUser(int $userId = null)
    {
        return $this->transferTable->makeQuery()
        ->where('user_id = :userId OR recipient_id = :recipientId')
            ->setParameter('userId', $userId ?? $this->getUserId())
            ->setParameter('recipientId', $userId ?? $this->getUserId())
            ->join('users as u', 'u.id = f.recipient_id')->select('f.*', 'u.email');
    }
    public function getErrors():array
    {
        $errors = $this->session->get('fund_errors', []);
        $this->session->delete('fund_errors');
        return $errors;
    }

    public function makeTransfers($userId = false): array
    {
        $tmp = [];
        $transfers = $this->transferTable->fetchTransfers($userId ? $this->getUserId() : null);
        foreach ($transfers as $transfer) {
            $recipient = $this->userTable->find($transfer->recipientId);
            $recipient->addFund($transfer->amount);
            $this->userTable->updateWallet($recipient);
            $this->transferTable->update($transfer->id, ['updated_at' => date('Y-m-d H:i:s')]);
            $this->transferTable->accept($transfer->id);
            $tmp[] = "The transfer #" . $transfer->id . " completed successfully";
        }
        $this->success(join(',', $tmp));
        return $tmp;
    }

    public function addFund(\App\Shop\Entity\Transaction $transaction)
    {
        $recipient = $transaction->getUser();
        $recipient->addFund($transaction->getItems()[0]->getPrice());
        $this->userTable->updateWallet($recipient);
    }

    /**
     * @return \App\Fund\Database\TransferTable
     */
    public function getTransferTable(): TransferTable
    {
        return $this->transferTable;
    }

    public function cancel($id)
    {
        $transfer = $this->transferTable->find($id);
        if ($transfer->userId == $this->getUserId() && $transfer->state == 'pending') {
            $this->transferTable->update($transfer->id, ['updated_at' => date('Y-m-d H:i:s')]);
            $this->transferTable->cancel($transfer->id);
            $user = $this->getUser();

            $user->addFund($transfer->amount);
            $this->userTable->updateWallet($user);
            $this->flash->success('Done!');
        }
    }
}
