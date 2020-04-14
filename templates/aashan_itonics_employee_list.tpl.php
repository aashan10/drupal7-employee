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
    <th>Additional Info</th>
    <th>Actions</th>
    </thead>
    <tbody>
    <?php if (is_array($data) && count($data) > 0) : ?>
      <?php foreach ($data as $employee) : ?>
        <tr>
          <td><?= $employee->id ?></td>
          <td><?= $employee->name ?></td>
          <td><?= $employee->gender == 1 ? 'Male' : ($employee->gender == 0 ? 'Female' : 'Others') ?></td>
          <td><?= ucfirst($employee->address) ?></td>
          <td><?= $employee->email ?></td>
          <td>
            <img src="<?= $base_url . '/sites/default/files/' . $employee->image ?>" alt="<?= $employee->name ?>"
                 height="100" width="100"/>
          </td>
          <td><?= $employee->projects ?></td>
          <td><?= $employee->remarks ?></td>
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
  <?php if (count($data)) : ?>
    <script type="text/javascript">
      let deleteButtons = document.getElementsByClassName('delete-employee');
      for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function (event) {
          let url = event.target.getAttribute('data-href');
          let confirmation = confirm('Are you sure you want to delete this employee?');
          if (confirmation) {
            window.location.href = url;
          }
        });
      }
    </script>
  <?php endif; ?>
</div>
