<?php
declare(strict_types = 1);

namespace FeatureToggle\Stub {
    function forTestingItShouldPushAnyCallableStrategy()
    {
        return true;
    }

    class ForTestingItShouldPushAnyCallableStrategy
    {
        public function __invoke()
        {
            return true;
        }
    }
}
