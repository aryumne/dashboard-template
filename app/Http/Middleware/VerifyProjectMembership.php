<?php

namespace App\Http\Middleware;

use App\Services\ProjectService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyProjectMembership
{
    protected $projectService;
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $project = $this->projectService->getById($request->route('uuid'));
        // if (auth()->user()->hasPermissionTo('all project')) return $next($request);
        // if (!$project) return abort(404, 'Project not found');
        // if (!$project->members->contains(auth()->user())) return abort(403);
        return $next($request);
    }
}
