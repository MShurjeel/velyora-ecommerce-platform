<main class="account-content">
    <div class="content-header">
        <h3>Account Settings</h3>
    </div>
    <div class="settings-block">
        <h4>Personal Information</h4>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" value="Sarah">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" value="Anderson">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="sarah@example.com">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" value="+1 (555) 123-4567">
                </div>
            </div>
            <div class="settings-actions">
                <button type="button" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
    <div class="settings-block">
        <h4>Email Preferences</h4>
        <div class="toggle-row">
            <div class="toggle-info">
                <h5>Order Updates</h5>
                <p>Receive notifications about your order status</p>
            </div>
            <input type="checkbox" class="toggle-switch" checked>
        </div>
        <div class="toggle-row">
            <div class="toggle-info">
                <h5>Promotions</h5>
                <p>Receive emails about new promotions and deals</p>
            </div>
            <input type="checkbox" class="toggle-switch">
        </div>
    </div>
    <div class="settings-block danger-zone">
        <h4>Delete Account</h4>
        <span class="danger-text">Once you delete your account, there is no going back. Please be certain.</span>
        <button type="button" class="btn-danger">Delete Account</button>
    </div>
</main>