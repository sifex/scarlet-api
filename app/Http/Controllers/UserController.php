<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log, DB;

class UserController extends Controller
{
  public function add($username, $clanID) {

    $user = DB::table('scar_users')->where('username', $username)->get();
    $key = md5(strtolower($username) . "E6hJ9X2AptWH6bqU32");
    if($user != null)
    {
      echo "User " . $username . " already in database";
    }
    elseif(DB::table('scar_users')->insert(
    [
      'username' => $username,
      'key' => $key,
      'clanid' => $clanID
    ]))
    {
      echo $username . " (" . $key . ") - " . $clanID;

      // Log
      Log::info('Created User: ' . $username . " (" . $key . ") - " . $clanID);

    }
  }

  public function info($var, $return)
  {
    // Log
    Log::info('Fetching info(' . $var . ') for: ' . $return);

    if(DB::table('scar_users')->where('key', $var)->first())
    {
      echo DB::table('scar_users')->where('key', $var)->first()->$return;
    }
  }

  public function install(Request $request, $key)
  {
    // Log
    Log::info('Installing Directory for ' . $key . ': ' . $var);


    if(DB::table('scar_users')->where('key', $var)->first())
    {
      DB::table('scar_users')->where('key', $var)->first()->$type;
    }


    $dbc = $this->DB;
    $this->logger->info("API Request: - Update Install: " . $args['key'] . " fetching " . $request->getParam('installDir'));


    $dbc->update("scar_users", ['installDir' => $request->getParam('installDir')], ['key' => $args['key']]);
    print_r($dbc->get("scar_users", 'installDir', ['key' => $args['key']]));
  }

  public function post(Request $request) {
    echo $request->name;
  }
}
