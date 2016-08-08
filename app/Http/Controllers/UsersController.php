<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Own\Own;

use App\User;

use Hash;

use DB;
	
	/**
	* 
	*/
	class UsersController extends Controller
	{
		
		public function addUser(Request $request){

	        $inputs = $request->toArray();

	        $user = new User;

	        $user->names = $inputs['names'];
	        $user->lastName = $inputs['lastName'];
	        $user->secondName = $inputs['secondName'];
	        $user->birthDate = $inputs['birthDate'];
	        $user->gender = $inputs['gender'];
	        $user->password = Hash::make($inputs['password']);
	        $user->email = $inputs['email'];
	        $user->phone = $inputs['phone'];
	        $user->whatsapp = (isset($inputs['whatsapp'])) ? 1 : 0;
	        $user->curp = $inputs['curp'];
	        $user->street = $inputs['street'];
	        $user->gmap = $inputs['gmap'];

	        $status = $user->save();

	        // $message = '';

	        // if($status != 1){

	        // }

	        // Own::d($user);

	        // return 'Done Man!';

	        // Own::d($inputs);

	    }


	    public function showUsers(){

	    	$users = json_decode(
	    		json_encode(
	    			DB::table('users')->get()
    			), true);

	    	// Own::d($users);

	    	// return view('showUsers')->with($users);
// 
	    	return view('showUsers', ['users' => $users]);

	    }

	}

?>