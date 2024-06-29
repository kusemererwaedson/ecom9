<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "/admin/check-admin-password",
        "/admin/update-admin-status",
        "/admin/update-section-status",
        "/admin/update-category-status",
        "/admin/append-categories-level",
        "/admin/update-brand-status", 
        "/admin/update-product-status", 
        "/admin/update-attribute-status",               
        "/admin/update-image-status", 
        "/admin/update-banner-status", 
        "/admin/update-filter-status",
        "/admin/update-filter-value-status",
        "/admin/category-filters",       
        "/user/register", 
    ];
}
