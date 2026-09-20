<?php

return [
    'between' => [
        'numeric' => ':Attribute phải nằm trong khoảng :min đến :max.',
        'string' => ':Attribute phải từ :min đến :max ký tự.',
    ],
    'integer' => ':Attribute phải là số nguyên.',
    'max' => [
        'numeric' => ':Attribute không được lớn hơn :max.',
        'string' => ':Attribute không được dài quá :max ký tự.',
    ],
    'min' => [
        'numeric' => ':Attribute phải lớn hơn hoặc bằng :min.',
        'string' => ':Attribute phải có ít nhất :min ký tự.',
    ],
    'required' => 'Vui lòng nhập :attribute.',
    'string' => ':Attribute phải là chuỗi ký tự.',
    'unique' => ':Attribute đã tồn tại.',

    'attributes' => [
        'username' => 'tên đăng nhập',
        'password' => 'mật khẩu',
        'name' => 'tên lớp',
        'grade' => 'khối',
    ],
];
