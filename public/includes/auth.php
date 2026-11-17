<?php
session_start();

function isLoggedIn() {
  return isset($_SESSION['user_id']);
}

function currentUser() {
  return isLoggedIn() ? [
    'id'   => $_SESSION['user_id'],
    'name' => $_SESSION['user_name'],
    'role' => $_SESSION['user_role'],
  ] : null;
}

function requireLogin() {
  if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
  }
}

function requireRole($roles) {
  requireLogin();
  $role = $_SESSION['user_role'];
  if (!in_array($role, (array)$roles) && $role !== 'ADMIN') {
    header('Location: index.php');
    exit;
  }
}
?>