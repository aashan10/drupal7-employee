<?php

/**
 * Controller action for showing employee list
 */
function aashan_itonics_get_employee_list() {
  $data = db_select(AASHAN_ITONICS_DB_TABLE)->fields(AASHAN_ITONICS_DB_TABLE)->execute()->fetchAllAssoc('id');
  return theme('aashan_itonics_employee_list', ['data' => $data]);
}
