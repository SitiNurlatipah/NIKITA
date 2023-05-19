<?php

if (! function_exists('job_multiskill')) {
    function job_multiskill($number)
    {
        if ($number >= 1) {
            return '<td class="font-weight-medium"><div class="ml-1 mt-2 badge badge-warning">Transfered</div></td>';
        }
        else{
            return '<td class="font-weight-medium"><div class="ml-1 mt-2 badge badge-warning">Ready to Transfer</div></td>';
        }
    }
}
