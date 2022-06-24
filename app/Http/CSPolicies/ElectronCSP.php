<?php

namespace App\Http\CSPolicies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class ElectronCSP extends Basic
{
    public function configure()
    {
//        parent::configure();
//
//        $this
//            ->addDirective(Directive::SCRIPT, 'self')
//            ->addDirective(Directive::STYLE, 'self')
//            ->addDirective(Directive::IMG, 'self')
//            ->addDirective(Directive::IMG, 'self')
//            ->addDirective(Directive::IMG, 'pbs.twimg.com')
//            ->addDirective(Directive::STYLE, 'pro.fontawesome.com')
//            ->addDirective(Directive::SCRIPT, 'localhost')
//            ->addDirective(Directive::SCRIPT, 'localhost:3000')
//            ->addDirective(Directive::IMG, 'localhost:3000')
//            ->addDirective(Directive::CONNECT, 'ws://localhost:3000');

        $this->reportOnly();
    }
}
