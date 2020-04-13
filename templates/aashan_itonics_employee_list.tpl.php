<?php /** @var $data array */ global $base_url; ?>
<div class="aashan_itonics_employee">
  <div class="employee-header">
    <a href="<?= $base_url . '/employee/create' ?>" class="button">+ Add Employee</a>
  </div>
  <?php if (is_array($data) && count($data) > 0) : ?>
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
      <?php foreach ($data as $employee) : ?>
      <tr>
        <td><?= $employee->id ?></td>
        <td><?= $employee->name ?></td>
        <td><?= ucfirst($employee->gender) ?></td>
        <td><?= ucfirst($employee->address) ?></td>
        <td><?= $employee->email ?></td>
        <td>
          <img src="<?= $base_url . '/sites/default/employee/' . $employee->image?>" alt="<?= $employee->name ?>" height="100" width="100"/>
        </td>
        <td><?= $employee->projects ?></td>
        <td><?= $employee->remarks ?></td>
        <td>
          <a href="<?= $base_url . '/employee/' . $employee->id . '/edit' ?>">Edit</a>
          <a href="<?= $base_url . '/employee/' . $employee->id . '/' ?>">View</a>
          <a href="<?= $base_url . '/employee/' . $employee->id . '/delete' ?>">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>There are no records!</p>
  <?php endif; ?>
</div>
