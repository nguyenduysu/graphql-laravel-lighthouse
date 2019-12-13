<form action="{{ route('postLogin') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="email">
        <label>Password</label>
        <input type="password" name="password">
        <input type="submit" value="Login">
    </div>
</form>

