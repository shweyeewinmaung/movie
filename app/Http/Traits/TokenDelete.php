<?php
namespace App\Http\Traits;
use DB;

trait TokenDelete {

  public function old_token_delete($token)
  {

    if ($token->token->name == 'Android') {
      DB::table('oauth_access_tokens')
      ->where('user_id', $token->token->user_id)
      ->where('name','Android')
      ->where('id', '!=', $token->token->id)
      ->delete();
    }
    // else {
    //   DB::table('oauth_access_tokens')
    //   ->where('user_id', $token->token->user_id)
    //   ->where('name','Frontend')
    //   ->where('id', '!=', $token->token->id)
    //   ->delete();
    // }

  }

}
