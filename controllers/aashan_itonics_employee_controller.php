<?php

/**
 * Renders employee list page.
 * @return string
 * @throws Exception
 */
function aashan_itonics_get_employee_list()
{
  $data = db_select(AASHAN_ITONICS_DB_TABLE)->fields(AASHAN_ITONICS_DB_TABLE)->execute()->fetchAllAssoc('id');
  return theme('aashan_itonics_employee_list', ['data' => $data]);
}

/**
 * Prepares form for creating employees.
 * @param $form
 * @param $form_state
 * @return array
 */
function aashan_itonics_create_employee_form($form, &$form_state)
{
  $form = [
    'name' => [
      '#type' => 'textfield',
      '#title' => t('Employee Name'),
      '#required' => true
    ],
    'email' => [
      '#type' => 'textfield',
      '#title' => t('Employee Email'),
      '#required' => true
    ],
    'image' => [
      '#type' => 'file',
      '#title' => t('Employee Image')
    ],
    'address' => [
      '#type' => 'select',
      '#title' => t('Employee Address'),
      '#required' => true,
      '#options' => [
        'Kathmandu' => 'Kathmandu',
        'Lalitpur' => 'Lalitpur',
        'Bhaktapur' => 'Bhaktapur',
      ]
    ],
    'gender' => [
      '#type' => 'radios',
      '#title' => t('Employee Gender'),
      '#required' => true,
      '#options' => [
        '0' => 'Female',
        '1' => 'Male',
        '2' => 'Others',
      ]
    ],
    'projects' => [
      '#type' => 'textarea',
      '#title' => t('Projects')
    ],
    'remarks' => [
      '#type' => 'text_format',
      '#title' => t('Additional Details')
    ],
    'submit' => [
      '#type' => 'submit',
      '#value' => t('Create Employee')
    ],
    '#method' => 'post'
  ];
  return $form;
}

/**
 * Returns validator array for image upload.
 * @return array
 */
function aashan_itonics_get_image_validator()
{
  return [
    'file_validate_size' => ['2048000'],
    'file_validate_extensions' => ['jpg png gif jpeg bmp']
  ];
}

///**
// * Validates email during create action
// * @param $form
// * @param $form_state
// */
//function aashan_itonics_create_employee_form_validate($form, &$form_state) {
//  if(!filter_var($form_state['input']['email'], FILTER_VALIDATE_EMAIL)) {
//    drupal_set_message(t('The email field should be a valid email address'), 'error');
//    drupal_goto('/employee/create');
//  }
//}
//
///**
// * Validates email during edit action
// * @param $form
// * @param $form_state
// */
//function aashan_itonics_edit_employee_form_validate($form, &$form_state) {
//  if(!filter_var($form_state['input']['email'], FILTER_VALIDATE_EMAIL)) {
//    drupal_set_message(t('The email field should be a valid email address'), 'error');
//    drupal_goto('/employee/'. $form_state['input']['employee_id'] . '/edit');
//  }
//}
/**
 * Saves employee on form submit.
 * @param $form
 * @param $form_state
 * @throws Exception
 */
function aashan_itonics_create_employee_form_submit($form, &$form_state)
{
  $data = (object)$form_state['input'];
  $values = [
    'name' => $data->name,
    'email' => $data->email,
    'address' => $data->address,
    'gender' => $data->gender,
    'projects' => $data->projects,
    'remarks' => $data->remarks['value'],
  ];
  if(isset($_FILES['file']['name'])) {
    $is_uploaded = file_save_upload('image', aashan_itonics_get_image_validator(), 'public://');
    if($is_uploaded && property_exists($is_uploaded, 'filename')) {
      $values['image'] = $is_uploaded->filename;
    }
  }
  db_insert(AASHAN_ITONICS_DB_TABLE)->fields($values)->execute();
  drupal_set_message(t('The Employee was created successfully!'));
}

/**
 * Deletes employees
 * @param $id
 * @return string
 * @throws Exception
 */
function aashan_itonics_delete_employee($id)
{
  $employee = db_select(AASHAN_ITONICS_DB_TABLE)
    ->fields(AASHAN_ITONICS_DB_TABLE)
    ->condition('id', $id)
    ->execute()
    ->fetchAllAssoc('id');
  if ($employee) {
    $delete = db_delete(AASHAN_ITONICS_DB_TABLE)->condition('id', $id)->execute();
    if ($delete) {
      drupal_set_message('The employee was deleted successfully!');
    } else {
      drupal_set_message('The employee was not found!', 'error');
    }
  } else {
    drupal_set_message('The employee was not found!', 'error');
  }
  drupal_set_title(t('Employees'));
  return aashan_itonics_get_employee_list();
}

/**
 * Prepares employee edit form
 * @param $form
 * @param $form_state
 * @param $id
 * @return array
 */
function aashan_itonics_edit_employee_form($form, $form_state, $id)
{
  $employee = db_select(AASHAN_ITONICS_DB_TABLE)->fields(AASHAN_ITONICS_DB_TABLE)->condition('id', $id)->execute()->fetchAllAssoc('id');
  if (count($employee) > 0) {
    $employee = $employee[array_key_first($employee)];
    $form = aashan_itonics_create_employee_form($form, $form_state);
    $form['employee_id'] = [
      '#type' => 'hidden',
      '#value' => $employee->id
    ];
    $form['name']['#value'] = $employee->name;
    $form['address']['#value'] = $employee->address;
    $form['email']['#value'] = $employee->email;
    $form['gender']['#default_value'] = $employee->gender;
    $form['projects']['#value'] = $employee->projects;
    $form['remarks']['#value'] = $employee->remarks;
    $form['submit']['#value'] = t('Update Employee');
    return $form;
  } else {
    drupal_set_message(t('The employee you were trying to edit does not exist!'), 'error');
    drupal_goto('/employee');
    return [];
  }
}

/**
 * Updates employee on form submit
 * @param $form
 * @param $form_state
 */
function aashan_itonics_edit_employee_form_submit($form, &$form_state)
{
  $employee_id = $form_state['input']['employee_id'];
  $employee = db_select(AASHAN_ITONICS_DB_TABLE)
    ->fields(AASHAN_ITONICS_DB_TABLE)
    ->condition('id', $employee_id)
    ->execute()
    ->fetchAllAssoc('id');
  if (!$employee_id || !$employee) {
    drupal_set_message(t('The employee does not exist!'), 'error');
    drupal_goto('/employee');
    return;
  }
  $fields = [
    'name' => $form_state['input']['name'],
    'email' => $form_state['input']['email'],
    'address' => $form_state['input']['address'],
    'gender' => $form_state['input']['gender'],
    'projects' => $form_state['input']['projects'],
    'remarks' => $form_state['input']['remarks']['value']
  ];
  if (isset($_FILES['files']['name'])) {
    $file = file_save_upload('image', aashan_itonics_get_image_validator(), 'public://');
    if($file) {
      $fields['image'] = isset($file) ? $file->filename : $employee->image;
    }
  }
  $success = db_update(AASHAN_ITONICS_DB_TABLE)->fields($fields)->condition('id', $employee_id)->execute();
  if ($success) {
    drupal_set_message(t('Employee updated!'));
  } else {
    drupal_set_message(t('Employee was not updated!'), 'error');
  }
  drupal_goto('/employee');
}

/**
 * Renders employee details page
 * @param $id
 * @return int|string
 * @throws Exception
 */
function aashan_itonics_employee_details($id) {
  $employee = db_select(AASHAN_ITONICS_DB_TABLE)
    ->fields(AASHAN_ITONICS_DB_TABLE)
    ->condition('id', $id)
    ->execute()
    ->fetchAllAssoc('id');
  if( count($employee) > 0) {
    $employee = $employee[array_key_first($employee)];
    return theme('aashan_itonics_employee_view', ['employee' => $employee]);
  } else {
    drupal_set_message(t('The employee was not found!'), 'error');
    drupal_goto('/employee');
    return 0;
  }
}
