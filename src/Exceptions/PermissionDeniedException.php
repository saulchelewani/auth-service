<?php

namespace TNM\AuthService\Exceptions;

use Illuminate\Http\Response;

class PermissionDeniedException extends AbstractException
{

    protected function addMessage(): string
    {
        return 'You are not permitted to access this resource';
    }

    protected function addCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
