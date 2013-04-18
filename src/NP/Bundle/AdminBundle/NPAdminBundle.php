<?php

namespace NP\Bundle\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NPAdminBundle extends Bundle {

    public function getParent() {
        return 'CmsAdminBundle';
    }

}
