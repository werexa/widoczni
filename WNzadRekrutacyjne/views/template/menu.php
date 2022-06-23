
<header class="masthead mb-auto">
    <div class="inner">
        <h3 class="masthead-brand"><?php echo $this->name ?? "main" ?></h3>
        <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link <?php echo empty($this->name) ? "active" : "" ?>" href="index.php">main</a>
            <a class="nav-link" <?php echo $this->name=="client" ? "active" : ""?> href="index.php?action=client">Clients</a>
            <a class="nav-link" <?php echo ($this->name=="employee") ? "active" : ""?>href="index.php?action=employee">Employees</a>
            <a class="nav-link" <?php  echo $this->name=="contacts" ? "active" : ""?>href="index.php?action=contacts">Contacts</a>
            <a class="nav-link" <?php  echo $this->name=="package" ? "active" : ""?>href="index.php?action=package">Packages</a>
        </nav>
    </div>
</header>

