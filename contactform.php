<form action="https://api.web3forms.com/submit" method="POST">

    <!-- Replace with your Access Key -->
    <input type="hidden" name="access_key" value="9aabb81d-181d-4586-8558-17ffd173e3f3">

    <!-- Form Inputs. Each input must have a name="" attribute -->
    <input type="text" name="name" required>
    <input type="email" name="email" required>
    <textarea name="message" required></textarea>

    <!-- Honeypot Spam Protection -->
    <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

    <button type="submit">Submit Form</button>

</form>