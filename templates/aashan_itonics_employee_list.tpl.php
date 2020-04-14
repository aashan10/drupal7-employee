<?php

/** @var $data array */

global $base_url;

?>
<div class="aashan_itonics_employee">
  <div class="employee-header">
    <a href="<?= $base_url . '/employee/create' ?>" class="button">+ Add Employee</a>
  </div>
  <table>
    <thead>
    <th>ID</th>
    <th>Name</th>
    <th>Gender</th>
    <th>Address</th>
    <th>Email</th>
    <th>Photo</th>
    <th>Projects</th>
    <th>Actions</th>
    </thead>
    <tbody>
    <?php if (is_array($data) && count($data) > 0) : ?>
      <?php foreach ($data as $employee) : ?>
        <tr>
          <td><?= $employee->id ?></td>
          <td><?= htmlentities($employee->name) ?></td>
          <td><?= $employee->gender == 1 ? 'Male' : ($employee->gender == 0 ? 'Female' : 'Others') ?></td>
          <td><?= htmlentities($employee->address) ?></td>
          <td><?= htmlentities($employee->email) ?></td>
          <td>
            <img src="<?= $base_url . '/sites/default/files/' . $employee->image ?>" alt="<?= $employee->name ?>"
                 height="100" width="100"/>
          </td>
          <td><?= htmlentities($employee->projects) ?></td>
          <td>
            <a href="<?= $base_url . '/employee/' . $employee->id . '/edit' ?>">Edit</a>
            <a href="<?= $base_url . '/employee/' . $employee->id . '/' ?>">View</a>
            <a class="delete-employee"
               data-href="<?= $base_url . '/employee/' . $employee->id . '/delete' ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>There are no records!</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php endif; ?>
    </tbody>
  </table>
</div>
