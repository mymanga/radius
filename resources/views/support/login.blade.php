<!-- resources/views/support/login.blade.php -->

<!-- resources/views/support/login.blade.php -->

<form action="{{ route('support.login') }}" method="post">
    @csrf
    <label for="special_key">Special Key:</label>
    <input type="text" name="special_key" required>
    <br>
    @error('special_key')
        <div>{{ $message }}</div>
    @enderror
    <br>
    <button type="submit">Login</button>
</form>
