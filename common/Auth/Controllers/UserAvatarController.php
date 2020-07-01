<?php namespace Common\Auth\Controllers;

use Common\Auth\Events\UserAvatarChanged;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\JsonResponse;
use Intervention\Image\ImageManagerStatic;
use Storage;
use App\User;
use Illuminate\Http\Request;
use Common\Core\BaseController;

class UserAvatarController extends BaseController {

    /**
     * @var Request
     */
    private $request;

    /**
     * @var User
     */
    private $user;

    /**
     * @var FilesystemAdapter
     */
    private $storage;

    /**
     * @param Request $request
     * @param User $user
     */
    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->storage = Storage::disk('public');
        $this->user = $user;
    }

    /**
     * @param int $userId
     * @return JsonResponse
     */
    public function store($userId) {

        $user = $this->user->findOrFail($userId);

        $this->authorize('update', $user);

        $this->validate($this->request, [
            'file' => 'required|image|max:10280',
        ]);

        // delete old user avatar
        $this->storage->delete($user->getRawOriginal('avatar'));

        // store new avatar on public disk

        $eee = $this->request->file('file')->getFilename();
        $path = $this->request->file('file')->storePublicly('avatars', ['disk' => 'public']);

        //the image will be replaced with an optimized version which should be smaller
        $img = ImageManagerStatic::make('storage/'.$path);
        $img->fit(128);
        $img->save('storage/'.$path, 50);

        // attach avatar to user model
        $user->avatar = $path;
        $user->save();

        event(new UserAvatarChanged($user));

        return $this->success([
            'user' => $user,
            'fileEntry' => ['url' => "storage/$path"]
        ]);
    }

    /**
     * @param int $userId
     * @return User
     */
    public function destroy($userId)
    {
        $user = $this->user->findOrFail($userId);

        $this->authorize('update', $user);

        $this->storage->delete($user->getOriginal('avatar'));

        $user->avatar = null;
        $user->save();

        event(new UserAvatarChanged($user));

        return $user;
    }
}
