<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $users = User::query();
        if ($request->search) {
            $users->where(fn($q) => $q->where('name','like',"%{$request->search}%")->orWhere('email','like',"%{$request->search}%"));
        }
        return $this->success(UserResource::collection($users->paginate(15)));
    }

    public function show(User $user) { return $this->success(new UserResource($user)); }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'organisation' => 'nullable|string|max:255',
            'job_title'    => 'nullable|string|max:255',
            'avatar'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        } elseif (array_key_exists('avatar', $data)) {
            unset($data['avatar']); // don't nullify if no file provided
        }

        $user->update($data);
        return $this->success(new UserResource($user), 'Profile updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->success(null, 'User deleted');
    }

    public function me(Request $request) { return $this->success(new UserResource($request->user())); }
}
