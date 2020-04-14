<?php /** @var $employee stdClass */
global $base_url; ?>
<div class="employee-wrapper">
  <div class="row">
    <a class="button" href="<?= $base_url . '/employee/' . $employee->id . '/edit' ?>">Edit Employee</a>
  </div>
  <div class="row">
    <div class="column">
      <div class="row">
        <span class="label">Name</span>
        <span> <?= htmlentities($employee->name) ?> </span>
      </div>
      <div class="row">
        <span class="label"> Email </span>
        <span> <?= htmlentities($employee->email) ?> </span>
      </div>
      <div class="row">
        <span class="label">Gender</span>
        <?php if($employee->gender == 1) : ?>
          <span> Male </span>
        <?php elseif($employee->gender == 0) : ?>
          <span> Female </span>
        <?php else : ?>
          <span> Others </span>
        <?php endif; ?>
      </div>
      <div class="row">
        <span class="label">Address</span>
        <span><?= htmlentities($employee->address) ?></span>
      </div>
    </div>
    <div class="column">
      <img src="<?= $base_url . '/sites/default/files/' . $employee->image ?>" class="img-responsive"/>
    </div>
  </div>
  <div class="row">
    <div class="column">
      <div class="row">
        <div>
          <span class="label">Projects</span>
          <br/>
          <br/>
          <?= $employee->projects ?>
        </div>
      </div>
      <div class="row">
        <div>
          <span class="label">Additional Info</span>
          <br/>
          <br/>
          <?= $employee->remarks ?>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
  .employee-wrapper {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .row{
    flex : 1;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    vertical-align: middle;
  }
  .column {
    flex : 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .img-responsive {
    display: flex;
    flex : 1;
    width : 100%;
    max-width: 100%;
    padding-left : 10px;
    height : auto;
  }
  .label{
    font-weight: bold;
  }

  .column > .row {
    border-bottom: 1px solid #a6a7a2;
  }

  span {
    margin : auto 0 auto 0;
  }

</style>
