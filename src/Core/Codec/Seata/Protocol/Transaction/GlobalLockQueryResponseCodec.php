<?php

namespace Hyperf\Seata\Core\Codec\Seata\Protocol\Transaction;


use Hyperf\Seata\Core\Protocol\AbstractMessage;
use Hyperf\Seata\Core\Protocol\Transaction\GlobalLockQueryResponse;
use Hyperf\Seata\Utils\Buffer\ByteBuffer;

class GlobalLockQueryResponseCodec extends AbstractTransactionResponseCodec
{
    public function getMessageClassType(): string
    {
        return GlobalLockQueryResponse::class;
    }

    public function encode(AbstractMessage $message, ByteBuffer $buffer): ByteBuffer
    {
        parent::encode($message, $buffer);

        if (! $message instanceof GlobalLockQueryResponse) {
            throw new \InvalidArgumentException('Invalid message');
        }

        $buffer->putUShort($message->isLockable() ? 1 : 0);
    }

    public function decode(AbstractMessage $message, ByteBuffer $buffer): AbstractMessage
    {
        parent::decode($message, $buffer);

        if (! $message instanceof GlobalLockQueryResponse) {
            throw new \InvalidArgumentException('Invalid message');
        }

        $message->setLockable($buffer->readUShort() === 1);
    }

}