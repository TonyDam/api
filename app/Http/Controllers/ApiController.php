<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Session;


class ApiController extends Controller
{
    protected $userRepository;

    protected $nbrPerPage = 4;

    public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function index(User $user)
	{
		$users = $this->userRepository;
        return $user ->get();
	}

	public function create()
	{
		return view('create');
	}

	public function store(UserCreateRequest $request)
	{ 
		
		$validator = Validator::make($request->all(), [
			'name' => ['required','max:255'],
			'email' => ['required','email','unique:users'],
			'password' => ['required','confirmed','min:6'],
			'password_confirmation' => ['required']
		]);
		if ($validator->fails()) {
			 Session::flash('error', $validator->messages()->first());
			 return redirect()->back()->withInput();
		}
		$validated = $request->validated();
		$user = $this->userRepository->store($request->all());
		
		return $user ;
	}

	public function show($id)
	{
		$user = $this->userRepository->getById($id);

		return $user;
	}

	public function edit($id)
	{
		$user = $this->userRepository->getById($id);

		return view('edit',  compact('user'));
	}

	public function update(UserUpdateRequest $request, $id)
	{	
	
		$validator = Validator::make($request->all(), [
			'name' => ['required','max:255','unique:users'],
			'email' => ['required','email','unique:users'],
			'password' => ['required','confirmed','min:6'],
			'password_confirmation' => ['required']
		]);
	
		if ($validator->fails()) {
			 Session::flash('error', $validator->messages()->first());
			 return redirect()->back()->withInput();
		}
		$this->userRepository->update($id, $request->all());
		$validated = $request->validated();
		$user = $this->userRepository->getById($id);
		
		return $user;
	}

	public function destroy($id)
	{
		$user = $this->userRepository->getById($id);
		$this->userRepository->destroy($id);
        return $user;
	}


}
