<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    /**
     * Display a listing of staff members.
     */
    public function index(Request $request): View
    {
        // Check if user can manage staff
        if (!auth()->user()->canManageStaff()) {
            abort(403, 'Unauthorized action.');
        }

        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $staff = $query->orderBy('name')->paginate(15);

        // Get counts for filters
        $counts = [
            'total' => User::count(),
            'managers' => User::where('role', 'manager')->count(),
            'pharmacists' => User::where('role', 'pharmacist')->count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
        ];

        return view('staff.index', compact('staff', 'counts'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create(): View
    {
        // Check if user can manage staff
        if (!auth()->user()->canManageStaff()) {
            abort(403, 'Unauthorized action.');
        }

        return view('staff.create');
    }

    /**
     * Store a newly created staff member.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if user can manage staff
        if (!auth()->user()->canManageStaff()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:pharmacist,manager',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member added successfully!');
    }

    /**
     * Display the specified staff member.
     */
    public function show(User $staff): View
    {
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(User $staff): View
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member.
     */
    public function update(Request $request, User $staff): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->id,
            'role' => 'required|in:pharmacist,manager',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $staff->update($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member updated successfully!');
    }

    /**
     * Remove the specified staff member.
     */
    public function destroy(User $staff): RedirectResponse
    {
        // Prevent deleting the last manager
        if ($staff->isManager() && User::where('role', 'manager')->count() <= 1) {
            return redirect()->route('staff.index')
                ->with('error', 'Cannot delete the last manager. At least one manager must remain.');
        }

        // Prevent self-deletion
        if ($staff->id === auth()->id()) {
            return redirect()->route('staff.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff member deleted successfully!');
    }

    /**
     * Toggle staff member active status.
     */
    public function toggleStatus(User $staff): RedirectResponse
    {
        // Prevent deactivating the last manager
        if ($staff->isManager() && !$staff->is_active && User::where('role', 'manager')->where('is_active', true)->count() <= 1) {
            return redirect()->route('staff.index')
                ->with('error', 'Cannot deactivate the last active manager.');
        }

        $staff->update(['is_active' => !$staff->is_active]);

        $status = $staff->is_active ? 'activated' : 'deactivated';
        return redirect()->route('staff.index')
            ->with('success', "Staff member {$status} successfully!");
    }

    /**
     * Reset staff member password.
     */
    public function resetPassword(Request $request, User $staff): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $staff->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('staff.index')
            ->with('success', 'Password reset successfully!');
    }
}
