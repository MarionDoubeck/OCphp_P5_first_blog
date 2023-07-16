
<form method="post" action="app/services/sendmail.php">
    <div class="form-floating">
        <label for="name"  class="form-label">Nom</label>
        <input type="text" name="name" id="name" class="form-control" value="" required>
    </div>
    <div class="form-floating">
        <label for="firstname"  class="form-label">Prénom</label>
        <input type="text" name="firstname" id="firstname" class="form-control" value="" required>
    </div>
    <div class="form-floating">
        <label for="email"  class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="" required>
    </div>
    <div class="form-floating">
        <label for="message" class="form-label">Votre message</label>
        <textarea name="message" id="message" class="form-control" rows="6" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
