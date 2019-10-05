<form action="http://192.168.2.53:8000/postPizza" method="post" >


  <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

  <input type="text" name="firstname" placeholder="First Name" />

  <input type="text" name="lastname" placeholder="Last Name" />

  <input type="submit" name="submit" />
</form> 


