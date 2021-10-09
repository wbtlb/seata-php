<?php

namespace Hyperf\Seata\Core\Codec\Seata\Protocol\Transaction;

use Hyperf\Seata\Core\Model\GlobalStatus;
use Hyperf\Seata\Core\Protocol\AbstractMessage;
use Hyperf\Seata\Core\Protocol\Transaction\AbstractGlobalEndResponse;
use Hyperf\Utils\Buffer\ByteBuffer;
use InvalidArgumentException;

class AbstractGlobalEndResponseCodec extends AbstractTransactionResponseCodec
{
    public function getMessageClassType(): string
    {
        return AbstractGlobalEndResponse::class;
    }

    public function encode(AbstractMessage $message, ByteBuffer $buffer): ByteBuffer
    {
        parent::encode($message, $buffer);

        if (! $message instanceof AbstractGlobalEndResponse) {
            throw new InvalidArgumentException('Invalid message');
        }

        $buffer->putUByte($message->getGlobalStatus());
    }

    public function decode(AbstractMessage $message, ByteBuffer $buffer): AbstractMessage
    {
        parent::decode($message, $buffer);

        if (! $message instanceof AbstractGlobalEndResponse) {
            throw new InvalidArgumentException('Invalid message');
        }

        $message->setGlobalStatus(new GlobalStatus((int) $buffer->readUByte()));
    }

}