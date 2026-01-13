<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LoginFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // halaman yang boleh diakses tanpa login
        $allowed = [
            '/',
            '/simpora/',
            '/simpora/auth/login',
            'login',
            '/auth/login',
            'auth/cek',
            '/register',
            '/simpora/register',
            '/simpora/auth/register-attempt',
        ];

        // Normalize $allowed (remove leading/trailing slashes)
        $allowed = array_map(fn($path) => trim($path, '/'), $allowed);

        // Get current URI and trim slashes
        $uri = trim(service('uri')->getPath(), '/');

        // Allow special routes first
        if (str_starts_with($uri, 'simpora/validasi-peserta/')) {
            return $request; // Allow access
        }

        // Allow pages in $allowed array
        if (in_array($uri, $allowed, true)) {
            return $request; // Allowed access
        }

        // Check login session
        $session = session(); // Make sure session is available
        if (!$session->get('isLoggedIn')) {
            // Redirect to login page if not logged in
            return redirect()->to('/');
        }

        // If logged in and not in allowed pages, continue request
        return $request;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
