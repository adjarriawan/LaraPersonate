<?php

namespace Octopy\Impersonate;

use Closure;
use Illuminate\Foundation\Auth\User;

final class ImpersonateAuthorization
{
    /**
     * @var Closure
     */
    protected Closure $impersonator;

    /**
     * @var Closure
     */
    protected Closure $impersonated;

    /**
     * @param  ImpersonateManager $impersonate
     */
    public function __construct(protected ImpersonateManager $impersonate)
    {
        //
    }

    /**
     * @param  Closure $param
     * @return ImpersonateAuthorization
     */
    public function impersonator(Closure $param) : ImpersonateAuthorization
    {
        $this->impersonator = $param;

        return $this;
    }

    /**
     * @param  Closure $param
     * @return ImpersonateAuthorization
     */
    public function impersonated(Closure $param) : ImpersonateAuthorization
    {
        $this->impersonated = $param;

        return $this;
    }

    /**
     * @param  string $name
     * @param  User   $user
     * @return bool
     */
    public function check(string $name, User $user) : bool
    {
        return call_user_func($this->$name, $user);
    }

    /**
     * @param  User $user
     * @return bool
     */
    public function checkImpersonator(User $user) : bool
    {
        return $this->check('impersonator', $user);
    }

    /**
     * @param  User $user
     * @return bool
     */
    public function checkImpersonated(User $user) : bool
    {
        return $this->check('impersonated', $user);
    }
}
