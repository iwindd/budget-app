<?php

return [
    'nav' => "ใบเบิกเงิน",
    'heading' => "ใบเบิกเงิน",
    'create-heading' => "ใบเบิกเงิน #:serial",
    'add-btn' => "เพิ่มใบเบิกเงิน",
    'budgets-header' => "ใบเบิกเงิน",
    'budgetitem-header' => "รายละเอียดใบเบิกเงิน",
    'input-serial' => "สัญญายืมเงินเลขที่",
    'input-date' => "วันที่",
    'input-name' => "ผู้เบิก",
    'input-user-placeholder' => "เลือกรายชื่อผู้เบิก",
    'input-value' => "จำนวนเงินที่ต้องการเบิก (รวมทั้งคณะเดินทาง)",
    'input-value-minimize' => "งบประมาณ",
    'input-value-placeholder' => "จำนวนที่ต้องการเบิก",
    'input-subject' => "ขออนุมัติเบิกค่าใช้จ่ายในการเดินทางไปราชการ",
    'input-header' => "เดินทางไปปฎิบัติราชการ",
    'input-header-placeholder' => "ที่ไหน",
    'input-office' => "ที่ทำการ",
    'input-invitation' => "เรียน",
    'input-order_at' => "ลงวันที่",
    'input-order_id' => "ตามคำสั่ง/บันทึกที่",
    'input-subject' => "เรื่อง",
    'input-subject-placeholder' => "เรื่องอะไร",
    'input-budget-owner-name' => "ข้าพเจ้า",
    'input-budget-owner-position' => "ตำแหน่ง",
    'input-budget-owner-affiliation' => "สังกัด",
    'dialog-back-btn' => "ย้อนกลับ",
    'dialog-cancel-btn' => "ยกเลิก",
    'dialog-confirm-btn' => "ค้นหา",
    'none-create-message' => "จำเป็นต้องป้อนข้อมูลใบเบิกให้ครบถ้วนเพื่อจัดการใบเบิกเงิน",
    'none-address-create-message' => "กรุณาเพิ่มรายละเอียดการเดินทางให้ครบถ้วน!",
    'none-expense-create-message' => "กรุณาเพิ่มรายการค่าใช้จ่ายให้ครบถ้วน!",
    /* EXPENSE */
    'expense-header' => "รายการค่าใช้จ่าย",
    'table-expense-name' => "ชื่อรายการ",
    'table-expense-days' => "วัน",
    'table-value-expense-days' => ":day วัน",
    'table-value-expense-all' => "ประเภทรวม",
    'table-expense-total' => "รวมทั้งสิ้น",
    'table-expense-action' => "เครื่องมือ",
    'table-expenses-not-found' => "ไม่พบค่าใช้จ่าย",
    'add-expense-btn' => "บันทึกค่าใช้จ่าย",
    'expense-budget-item-not-found' => "*จำเป็นต้องบันทึกรายละเอียดใบเบิกก่อนเพิ่มรายการค่าใช้จ่าย",
    /* COMPANION */
    'companion-header' => "คณะเดินทาง",
    'input-companion' => "รายชื่อ",
    'input-companion-placeholder' => "เลือกรายชื่อเพื่อเพิ่มคณะเดินทาง",
    'table-companion-name' => "ชื่อผู้ร่วมเดินทาง",
    'table-companion-type' => "ประเภท",
    'table-value-companion-type-owner' => "<span class='text-success'>ผู้สร้างใบเบิก</span>",
    'table-value-companion-type-companion' => "ผู้ร่วมเดินทาง",
    'table-companion-expense' => "ค่าใช้จ่าย",
    'table-value-companion-expense' => ":count รายการ | รวมทั้งสิ้น :sum บาท",
    'table-value-companion-address' => ":count รายการ | :days วัน :hours ชั่วโมง",
    'table-companion-address' => "การเดินทาง",
    'table-companion-action' => "เครื่องมือ",
    'table-companion-not-found' => "ไม่พบผู้ร่วมเดินทาง",
    'table-companion-caption' => "คณะเดินทาง",
    'add-companion-btn' => "เพิ่มคณะเดินทาง",
    'companion-budget-item-not-found' => "*จำเป็นต้องบันทึกรายละเอียดใบเบิกก่อนเพิ่มคณะเดินทาง",
    /* ADMIN DIALOG */
    'admin-add-dialog-header' => "ใบเบิกเงิน",
    /* ALERT "[bagName]variant<duration>:message" - bagName, duration is optional */
    'alert-budget-saved' => "[budget.message]success<3000>:บันทึกใบเบิกแล้ว!",
    'alert-budget-error' => "[budget.message]danger<3000>:ไม่สามารถบันทึกได้ กรุณาลองใหม่อีกครั้งภายหลัง!",
    'alert-companion-add' => "[budget.message]success<2000>:เพิ่มผู้ร่วมเดินทางแล้ว!",
    'alert-companion-remove' => "[budget.message]success<2000>:ลบผู้ร่วมเดินทางแล้ว!",
];
