<?php

namespace App\Libraries;

use CodeIgniter\View\View;

/**
 * View renderer dengan dukungan data pada $this->include().
 *
 * Pada CodeIgniter 4 bawaan, parameter kedua View::include() adalah $options
 * (cache/debug), bukan data view. Banyak partial di aplikasi ini memanggil:
 *
 *   $this->include('partials/form-kompetisi', ['formUrl' => $formUrl]);
 *
 * Tanpa override ini, variabel seperti $formUrl, $canValidate, dan $role
 * tidak tersedia di partial sehingga menimbulkan error / tampilan salah.
 */
class AppView extends View
{
    public function include(string $view, ?array $options = null, $saveData = true): string
    {
        if (! empty($options)) {
            $this->setData($options);
        }

        return parent::include($view, $options, $saveData);
    }
}
