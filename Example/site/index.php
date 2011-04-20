<h1 id="title">Example!</h1>
<form action="/view.php" method="post">
    <p>
        <label for="your_name">Your Name:</label>
        <input id="your_name" type="text" name="your_name" value="" />
    </p>
    
    <p>
        <label for="gender">Your Gender:</label>
        <select id="gender" name="gender">
            <option value="0">Male</option>
            <option value="1">Female</option>
            <option value="2">Other</option>
        </select>
    </p>

    <p>
        <input id="form_submit" type="submit" name="submit" value="Save" />
    </p>
</form>