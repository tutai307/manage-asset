<?php

/*
 * Reading, listening and writing practice for every unit of Tiếng Anh 6–9 (Global Success).
 *
 * Drafted with `php artisan curriculum:build-exercise-seed`, written fresh from each unit's
 * vocabulary — never copied from a textbook (ADR-0005). Shipped so that a new installation
 * has practice for all 48 units without any AI call. Teachers edit these in the unit page;
 * the seeder never touches a unit that already has exercises.
 *
 * Key: "<grade>-<unit number>" => "<skill>" => exercise.
 */

return [
    '6-1' => [
        'reading' => [
            'title_en' => 'My New School',
            'title_vi' => 'Trường mới của em',
            'instructions_en' => 'Read the passage about Linh\'s new school. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về trường mới của Linh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'My name is Linh. I have a new school. It is big and beautiful. There are twenty students in my class. My classroom has five desks and twenty chairs. There are many books on the desks. I have a pen, a pencil, and a notebook. My teacher is very kind. We have English, Mathematics, and Science every day. I like my new school very much.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many students are in Linh\'s class?',
                    'options' => [
                        0 => 'Fifteen students',
                        1 => 'Twenty students',
                        2 => 'Twenty-five students',
                        3 => 'Thirty students',
                    ],
                    'answer' => 'Twenty students',
                    'explanation_vi' => 'Đoạn văn nói \'There are twenty students in my class.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh\'s classroom have?',
                    'options' => [
                        0 => 'Ten desks and fifteen chairs',
                        1 => 'Three desks and twenty chairs',
                        2 => 'Five desks and twenty chairs',
                        3 => 'Five desks and ten chairs',
                    ],
                    'answer' => 'Five desks and twenty chairs',
                    'explanation_vi' => 'Đoạn văn nói \'My classroom has five desks and twenty chairs.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which subjects does Linh have every day?',
                    'options' => [
                        0 => 'English and Mathematics',
                        1 => 'English, Mathematics, and Science',
                        2 => 'Mathematics and Science',
                        3 => 'English and Science',
                    ],
                    'answer' => 'English, Mathematics, and Science',
                    'explanation_vi' => 'Đoạn văn nói \'We have English, Mathematics, and Science every day.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Linh\'s school is small.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'It is big and beautiful\', không phải small.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh has a pen, a pencil, and a ___.',
                    'options' => null,
                    'answer' => 'notebook',
                    'explanation_vi' => 'Câu trong đoạn văn là \'I have a pen, a pencil, and a notebook.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'My New School',
            'title_vi' => 'Trường mới của em',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe hai lần. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hello, I am a new student at this school. My name is Linh.
Mr. Tuan: Welcome, Linh! I am your teacher. My name is Mr. Tuan.
Linh: Thank you, Mr. Tuan. This is a big school.
Mr. Tuan: Yes, it is. We have many classrooms and many students here.
Linh: Do you have English and Mathematics?
Mr. Tuan: Yes, we do. We have English, Mathematics, and Science. There are thirty students in your classroom.
Linh: Great! I have a new notebook and new pens.
Mr. Tuan: Very good, Linh!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is the teacher\'s name?',
                    'options' => [
                        0 => 'Mr. Linh',
                        1 => 'Mr. Tuan',
                        2 => 'Mr. Minh',
                    ],
                    'answer' => 'Mr. Tuan',
                    'explanation_vi' => 'Giáo viên nói: \'My name is Mr. Tuan.\' (Tên tôi là thầy Tuấn.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many students are in Linh\'s classroom?',
                    'options' => [
                        0 => 'twenty',
                        1 => 'thirty',
                        2 => 'forty',
                    ],
                    'answer' => 'thirty',
                    'explanation_vi' => 'Thầy Tuấn nói: \'There are thirty students in your classroom.\' (Có ba mươi học sinh trong lớp của em.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What subjects does the school have?',
                    'options' => [
                        0 => 'English and Mathematics',
                        1 => 'English, Mathematics, and Science',
                        2 => 'Science and Mathematics',
                    ],
                    'answer' => 'English, Mathematics, and Science',
                    'explanation_vi' => 'Thầy Tuấn nói: \'We have English, Mathematics, and Science.\' (Chúng tôi có tiếng Anh, toán học và khoa học.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh has a new ___ and new pens.',
                    'options' => null,
                    'answer' => 'notebook',
                    'explanation_vi' => 'Linh nói: \'I have a new notebook and new pens.\' (Em có một vở mới và những cái bút mới.)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Describe Your New School',
            'title_vi' => 'Mô tả trường học mới của em',
            'instructions_en' => 'Write about your new school. Use \'have/has\' to talk about what your school has, and \'there is/there are\' to describe things in your classroom. Write 50-80 words.',
            'instructions_vi' => 'Viết về trường học mới của em. Dùng \'have/has\' để nói về những gì trường em có, và \'there is/there are\' để mô tả những thứ trong lớp học. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your new school. Include:
- What your school has (use \'My school has...\' or \'There are...\')
- What is in your classroom (use \'There is...\' or \'There are...\')
- What subjects you have and what you have in your bag (use \'I have...\' or \'We have...\')',
            'prompt_vi' => 'Viết về trường học mới của em. Bao gồm:
- Trường em có những gì (dùng \'My school has...\' hoặc \'There are...\')
- Những gì có trong lớp học của em (dùng \'There is...\' hoặc \'There are...\')
- Những môn học em có và những gì em có trong cặp (dùng \'I have...\' hoặc \'We have...\')',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-2' => [
        'reading' => [
            'title_en' => 'Linh\'s House',
            'title_vi' => 'Ngôi nhà của Linh',
            'instructions_en' => 'Read the passage about Linh\'s house. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về ngôi nhà của Linh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh has a small house in Hà Nội. Her house has five rooms: a bedroom, a living room, a kitchen, a bathroom, and a study room. In her bedroom, there is a bed next to the window. Under the bed, there are two boxes. In the living room, there is a sofa between two chairs. The table is next to the sofa. In the kitchen, there is a table on the wall. Linh likes her house very much.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where is Linh\'s bed?',
                    'options' => [
                        0 => 'Next to the window',
                        1 => 'Under the table',
                        2 => 'Between two chairs',
                        3 => 'On the wall',
                    ],
                    'answer' => 'Next to the window',
                    'explanation_vi' => 'Đoạn văn nói \'In her bedroom, there is a bed next to the window.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many rooms does Linh\'s house have?',
                    'options' => [
                        0 => 'Three rooms',
                        1 => 'Four rooms',
                        2 => 'Five rooms',
                        3 => 'Six rooms',
                    ],
                    'answer' => 'Five rooms',
                    'explanation_vi' => 'Đoạn văn nói \'Her house has five rooms: a bedroom, a living room, a kitchen, a bathroom, and a study room.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is between two chairs in the living room?',
                    'options' => [
                        0 => 'A bed',
                        1 => 'A sofa',
                        2 => 'A table',
                        3 => 'A window',
                    ],
                    'answer' => 'A sofa',
                    'explanation_vi' => 'Đoạn văn nói \'In the living room, there is a sofa between two chairs.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'There are boxes under Linh\'s bed.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'Under the bed, there are two boxes.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The table in the kitchen is ___ the wall.',
                    'options' => null,
                    'answer' => 'on',
                    'explanation_vi' => 'Đoạn văn nói \'In the kitchen, there is a table on the wall.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'My House',
            'title_vi' => 'Ngôi nhà của em',
            'instructions_en' => 'Listen to the conversation about a house. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về ngôi nhà. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! Welcome to my house!
Minh: Thank you, Linh! Your house is very nice. Where is your bedroom?
Linh: My bedroom is upstairs. The bed is next to the window. My desk is under the window.
Minh: That sounds nice! Where is the living room?
Linh: The living room is downstairs. The sofa is between the table and the door. The chairs are on the sofa.
Minh: Great! Do you have a kitchen?
Linh: Yes! The kitchen is next to the bathroom.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where is Linh\'s bed?',
                    'options' => [
                        0 => 'Next to the window',
                        1 => 'Under the window',
                        2 => 'Between the table and the door',
                    ],
                    'answer' => 'Next to the window',
                    'explanation_vi' => 'Linh nói: \'The bed is next to the window.\' (Giường bên cạnh cửa sổ.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where is the sofa in the living room?',
                    'options' => [
                        0 => 'Under the table',
                        1 => 'Between the table and the door',
                        2 => 'Next to the bedroom',
                    ],
                    'answer' => 'Between the table and the door',
                    'explanation_vi' => 'Linh nói: \'The sofa is between the table and the door.\' (Ghế sofa ở giữa bàn và cửa.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is next to the bathroom?',
                    'options' => [
                        0 => 'The bedroom',
                        1 => 'The kitchen',
                        2 => 'The living room',
                    ],
                    'answer' => 'The kitchen',
                    'explanation_vi' => 'Linh nói: \'The kitchen is next to the bathroom.\' (Nhà bếp bên cạnh phòng tắm.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh\'s desk is ___ the window.',
                    'options' => null,
                    'answer' => 'under',
                    'explanation_vi' => 'Linh nói: \'My desk is under the window.\' (Bàn của em ở dưới cửa sổ.)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Describe Your Bedroom',
            'title_vi' => 'Mô tả phòng ngủ của em',
            'instructions_en' => 'Write about your bedroom. Describe where the furniture and objects are in your room using prepositions of place (in, on, under, next to, between). Write 50-80 words.',
            'instructions_vi' => 'Viết về phòng ngủ của em. Mô tả vị trí của các đồ nội thất và vật dụng trong phòng bằng cách sử dụng các giới từ chỉ vị trí (in, on, under, next to, between). Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your bedroom. Include:
- The name of your room and 2-3 pieces of furniture in it
- Where each piece of furniture is (use in, on, under, next to, or between)
- One sentence about what you like about your room',
            'prompt_vi' => 'Viết về phòng ngủ của em. Bao gồm:
- Tên phòng và 2-3 đồ nội thất trong phòng
- Vị trí của mỗi đồ nội thất (sử dụng in, on, under, next to, hoặc between)
- Một câu về điều em thích ở phòng của em',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-3' => [
        'reading' => [
            'title_en' => 'My Best Friends',
            'title_vi' => 'Những người bạn tốt nhất của em',
            'instructions_en' => 'Read the passage about two friends. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về hai người bạn. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'My name is Linh. I have two best friends. Their names are Minh and Hoa. Minh is tall and has short black hair. He has brown eyes and he is very smart. Minh is kind and funny. He always makes me laugh. Hoa is short and has long curly hair. Her hair is black. She has big brown eyes and she is very friendly. Hoa is smart too. We like to play together after school. We are happy friends.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh look like?',
                    'options' => [
                        0 => 'He is tall with short black hair and brown eyes',
                        1 => 'He is short with long black hair and brown eyes',
                        2 => 'He is tall with long curly hair and black eyes',
                        3 => 'He is short with short black hair and brown eyes',
                    ],
                    'answer' => 'He is tall with short black hair and brown eyes',
                    'explanation_vi' => 'Đoạn văn nói Minh cao, có tóc đen ngắn và mắt nâu.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Hoa\'s personality like?',
                    'options' => [
                        0 => 'She is kind and funny',
                        1 => 'She is friendly and smart',
                        2 => 'She is tall and smart',
                        3 => 'She is short and kind',
                    ],
                    'answer' => 'She is friendly and smart',
                    'explanation_vi' => 'Đoạn văn nói Hoa rất thân thiện và thông minh.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many best friends does Linh have?',
                    'options' => [
                        0 => 'One friend',
                        1 => 'Two friends',
                        2 => 'Three friends',
                        3 => 'Four friends',
                    ],
                    'answer' => 'Two friends',
                    'explanation_vi' => 'Linh nói \'I have two best friends\' - em có hai người bạn tốt nhất.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Hoa has short straight hair.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói Hoa có tóc dài xoăn, không phải tóc ngắn thẳng.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh is ___ and funny. He always makes Linh laugh.',
                    'options' => null,
                    'answer' => 'kind',
                    'explanation_vi' => 'Đoạn văn nói \'Minh is kind and funny\' - Minh tốt bụng và hài hước.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'My Best Friend Linh',
            'title_vi' => 'Bạn tốt nhất của em là Linh',
            'instructions_en' => 'Listen to the conversation about a friend. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc trò chuyện về một người bạn. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh: Hi Hoa! Who is your best friend?
Hoa: My best friend is Linh. She is very kind and friendly.
Minh: What does she look like?
Hoa: She is tall and has long black hair. Her eyes are brown.
Minh: Is she smart?
Hoa: Yes, she is very smart and funny too. I like her very much.
Minh: She sounds nice!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Hoa\'s best friend\'s name?',
                    'options' => [
                        0 => 'Minh',
                        1 => 'Linh',
                        2 => 'Hoa',
                    ],
                    'answer' => 'Linh',
                    'explanation_vi' => 'Hoa nói: \'My best friend is Linh\' (Bạn tốt nhất của em là Linh).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What color is Linh\'s hair?',
                    'options' => [
                        0 => 'brown',
                        1 => 'black',
                        2 => 'curly',
                    ],
                    'answer' => 'black',
                    'explanation_vi' => 'Hoa nói: \'She has long black hair\' (Cô ấy có tóc dài màu đen).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which word describes Linh\'s personality?',
                    'options' => [
                        0 => 'short',
                        1 => 'funny',
                        2 => 'tall',
                    ],
                    'answer' => 'funny',
                    'explanation_vi' => 'Hoa nói: \'She is very smart and funny too\' (Cô ấy rất thông minh và hài hước nữa).',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh is ___ and has long black hair.',
                    'options' => null,
                    'answer' => 'tall',
                    'explanation_vi' => 'Hoa nói: \'She is tall and has long black hair\' (Cô ấy cao và có tóc dài màu đen).',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Describe Your Best Friend',
            'title_vi' => 'Mô tả bạn thân của em',
            'instructions_en' => 'Write a short paragraph about your best friend. Describe what they look like and their personality. Use \'have/has\' and \'be\' to describe their appearance and character.',
            'instructions_vi' => 'Viết một đoạn văn ngắn về bạn thân của em. Mô tả ngoại hình và tính cách của bạn. Sử dụng \'have/has\' và \'be\' để mô tả ngoại hình và tính cách.',
            'passage' => null,
            'prompt_en' => 'Write about your best friend. Include:
- Their name and what they look like (tall/short, hair color, hair type)
- What they have (eyes color)
- Their personality (kind, friendly, smart, funny, etc.)',
            'prompt_vi' => 'Viết về bạn thân của em. Bao gồm:
- Tên của bạn và ngoại hình của bạn (cao/thấp, màu tóc, kiểu tóc)
- Những gì bạn có (màu mắt)
- Tính cách của bạn (tốt bụng, thân thiện, thông minh, hài hước, v.v.)',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-4' => [
        'reading' => [
            'title_en' => 'Linh\'s Neighbourhood',
            'title_vi' => 'Khu phố của Linh',
            'instructions_en' => 'Read the passage about Linh\'s neighbourhood. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về khu phố của Linh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh lives in a nice neighbourhood in Hà Nội. Her house is on Nguyễn Huệ Street, near a small bridge. The school is opposite her house, next to a park. The market is far from her house. To go to the market, Linh walks straight on Nguyễn Huệ Street. Then she turns left at the corner. The library is between the market and the school. Her friend Minh\'s house is next to the library. Linh\'s neighbourhood is very quiet and beautiful.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where is Linh\'s house?',
                    'options' => [
                        0 => 'On Nguyễn Huệ Street, near a small bridge',
                        1 => 'Next to the market',
                        2 => 'Between the school and the library',
                        3 => 'Opposite the park',
                    ],
                    'answer' => 'On Nguyễn Huệ Street, near a small bridge',
                    'explanation_vi' => 'Đoạn văn nói \'Her house is on Nguyễn Huệ Street, near a small bridge.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is opposite Linh\'s house?',
                    'options' => [
                        0 => 'A bridge',
                        1 => 'A school and a park',
                        2 => 'The market',
                        3 => 'Minh\'s house',
                    ],
                    'answer' => 'A school and a park',
                    'explanation_vi' => 'Đoạn văn nói \'The school is opposite her house, next to a park.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How does Linh go to the market?',
                    'options' => [
                        0 => 'She turns right at the corner',
                        1 => 'She walks straight, then turns left at the corner',
                        2 => 'She walks near the bridge',
                        3 => 'She goes between the school and the library',
                    ],
                    'answer' => 'She walks straight, then turns left at the corner',
                    'explanation_vi' => 'Đoạn văn nói \'Linh walks straight on Nguyễn Huệ Street. Then she turns left at the corner.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'The library is between the market and the school.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'The library is between the market and the school.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh\'s house is ___ the library.',
                    'options' => null,
                    'answer' => 'next to',
                    'explanation_vi' => 'Đoạn văn nói \'Her friend Minh\'s house is next to the library.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Finding the Way in Hoan Kiem Neighbourhood',
            'title_vi' => 'Tìm đường trong khu phố Hoàn Kiếm',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh: Excuse me, where is the library?
An: The library is near here. Go straight on this street.
Minh: Is it far?
An: No, it is not far. Turn left at the corner.
Minh: Turn left?
An: Yes. The library is next to the bridge. It is opposite the park.
Minh: Thank you!
An: You are welcome!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where does Minh want to go?',
                    'options' => [
                        0 => 'To the park',
                        1 => 'To the library',
                        2 => 'To the bridge',
                    ],
                    'answer' => 'To the library',
                    'explanation_vi' => 'Minh hỏi \'Where is the library?\' nên Minh muốn đi đến thư viện.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Is the library far from Minh?',
                    'options' => [
                        0 => 'Yes, it is far',
                        1 => 'No, it is not far',
                        2 => 'We do not know',
                    ],
                    'answer' => 'No, it is not far',
                    'explanation_vi' => 'An nói \'No, it is not far\' - thư viện không xa.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is opposite the library?',
                    'options' => [
                        0 => 'The bridge',
                        1 => 'The park',
                        2 => 'The corner',
                    ],
                    'answer' => 'The park',
                    'explanation_vi' => 'An nói \'It is opposite the park\' - công viên ở đối diện thư viện.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The library is next to the ___.',
                    'options' => null,
                    'answer' => 'bridge',
                    'explanation_vi' => 'An nói \'The library is next to the bridge\' - thư viện bên cạnh cầu.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Describe Your Neighbourhood and Give Directions',
            'title_vi' => 'Mô tả khu phố của em và chỉ đường',
            'instructions_en' => 'Write a short description of your neighbourhood. Include where some places are located using prepositions of place, and give simple directions to one place. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn mô tả khu phố của em. Sử dụng các giới từ chỉ vị trí để nói về vị trí của các nơi, và chỉ đường đến một nơi. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your neighbourhood. Include:
- The name of your street or road and describe where some places are (use: near, far, between, opposite, next to)
- Simple directions to one place from your house (use: turn left/right, go straight)',
            'prompt_vi' => 'Viết về khu phố của em. Bao gồm:
- Tên đường phố của em và mô tả vị trí của một số nơi (sử dụng: near, far, between, opposite, next to)
- Chỉ đường đến một nơi từ nhà em (sử dụng: turn left/right, go straight)',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-5' => [
        'reading' => [
            'title_en' => 'Phong Nha-Ke Bang National Park',
            'title_vi' => 'Vườn quốc gia Phong Nha - Kẻ Bàng',
            'instructions_en' => 'Read the passage about a natural wonder in Vietnam. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về một kỳ quan thiên nhiên ở Việt Nam. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Phong Nha-Ke Bang is a natural wonder in Quang Binh province. There are many caves and mountains in this park. There is a beautiful waterfall near the entrance. There are not many beaches here, but there is a river with clear water. Many tourists visit this place every year. They pack their backpack with a camera, map, hiking boots, and sunscreen. There is no need to bring a compass because the park is not very big. Visitors can see the forest and enjoy nature.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What natural features are there in Phong Nha-Ke Bang?',
                    'options' => [
                        0 => 'Caves, mountains, and a waterfall',
                        1 => 'Only beaches and islands',
                        2 => 'Only forests and rivers',
                        3 => 'Mountains and beaches',
                    ],
                    'answer' => 'Caves, mountains, and a waterfall',
                    'explanation_vi' => 'Đoạn văn nói \'There are many caves and mountains in this park. There is a beautiful waterfall near the entrance.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should tourists pack in their backpack?',
                    'options' => [
                        0 => 'A compass and a map',
                        1 => 'A camera, map, hiking boots, and sunscreen',
                        2 => 'Only hiking boots and sunscreen',
                        3 => 'A backpack and luggage',
                    ],
                    'answer' => 'A camera, map, hiking boots, and sunscreen',
                    'explanation_vi' => 'Đoạn văn nói \'They pack their backpack with a camera, map, hiking boots, and sunscreen.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where is Phong Nha-Ke Bang located?',
                    'options' => [
                        0 => 'Ha Noi province',
                        1 => 'Ho Chi Minh City',
                        2 => 'Quang Binh province',
                        3 => 'Da Nang province',
                    ],
                    'answer' => 'Quang Binh province',
                    'explanation_vi' => 'Đoạn văn nói \'Phong Nha-Ke Bang is a natural wonder in Quang Binh province.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'There are many beaches in Phong Nha-Ke Bang.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'There are not many beaches here\' nên câu này là sai.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'There is a ___ with clear water in Phong Nha-Ke Bang.',
                    'options' => null,
                    'answer' => 'river',
                    'explanation_vi' => 'Đoạn văn nói \'there is a river with clear water\' để mô tả đặc điểm của công viên.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Planning a Trip to Phong Nha',
            'title_vi' => 'Lên kế hoạch đi du lịch Phong Nha',
            'instructions_en' => 'Listen to the conversation about a trip to Phong Nha cave. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về chuyến đi du lịch hang Phong Nha. Sau đó trả lời các câu hỏi.',
            'passage' => 'Minh: Hi Linh! Are you ready for our trip to Phong Nha?
Linh: Yes! I am very excited. There are beautiful caves and waterfalls there.
Minh: That\'s right. There is also a big mountain near the cave. We can hike!
Linh: Great! I have my backpack and hiking boots. What about you?
Minh: I have my camera and map. But there is no sunscreen in my backpack. Can you help me pack it?
Linh: Of course! There are many natural wonders in Phong Nha. We need sunscreen for the beach too!
Minh: Perfect! Let\'s go tomorrow!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What natural wonders are there in Phong Nha?',
                    'options' => [
                        0 => 'Caves, waterfalls, and a mountain',
                        1 => 'Only caves and a beach',
                        2 => 'Only waterfalls and a forest',
                    ],
                    'answer' => 'Caves, waterfalls, and a mountain',
                    'explanation_vi' => 'Linh nói \'There are beautiful caves and waterfalls there\' và Minh nói \'There is also a big mountain near the cave\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh NOT have in his backpack?',
                    'options' => [
                        0 => 'A camera',
                        1 => 'Sunscreen',
                        2 => 'A map',
                    ],
                    'answer' => 'Sunscreen',
                    'explanation_vi' => 'Minh nói \'But there is no sunscreen in my backpack.\' Anh ấy có máy ảnh và bản đồ.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh have for the trip?',
                    'options' => [
                        0 => 'A camera and a map',
                        1 => 'A backpack and hiking boots',
                        2 => 'Sunscreen and a compass',
                    ],
                    'answer' => 'A backpack and hiking boots',
                    'explanation_vi' => 'Linh nói \'I have my backpack and hiking boots.\' Đó là những thứ Linh có.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'There are many ___ in Phong Nha.',
                    'options' => null,
                    'answer' => 'natural wonders',
                    'explanation_vi' => 'Linh nói \'There are many natural wonders in Phong Nha.\' Đây là cách diễn tả các kỳ quan thiên nhiên.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Describe a Natural Wonder in Vietnam',
            'title_vi' => 'Mô tả một kỳ quan thiên nhiên ở Việt Nam',
            'instructions_en' => 'Write about a natural wonder in Vietnam. Use \'There is\' or \'There are\' to describe what you can find there. Say what you need to pack for your visit.',
            'instructions_vi' => 'Viết về một kỳ quan thiên nhiên ở Việt Nam. Sử dụng \'There is\' hoặc \'There are\' để mô tả những gì bạn có thể tìm thấy ở đó. Nói về những gì bạn cần đóng gói cho chuyến đi.',
            'passage' => null,
            'prompt_en' => 'Choose a natural wonder in Vietnam (for example: Ha Long Bay, Phong Nha Cave, Fansipan Mountain, or a waterfall). Write about it:
- Describe what natural features are there (use \'There is\' or \'There are\')
- Say what you will pack in your backpack
- Say what you will NOT pack (use negative \'There is not\' or \'There are not\')',
            'prompt_vi' => 'Chọn một kỳ quan thiên nhiên ở Việt Nam (ví dụ: Vịnh Hạ Long, Hang Phong Nha, Núi Fansipan, hoặc một thác nước). Viết về nó:
- Mô tả những đặc điểm thiên nhiên ở đó (sử dụng \'There is\' hoặc \'There are\')
- Nói những gì bạn sẽ đóng gói trong ba lô
- Nói những gì bạn sẽ KHÔNG đóng gói (sử dụng \'There is not\' hoặc \'There are not\' ở dạng phủ định)',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-6' => [
        'reading' => [
            'title_en' => 'Tet Holiday in Vietnam',
            'title_vi' => 'Ngày Tết ở Việt Nam',
            'instructions_en' => 'Read the passage about Tet traditions. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về truyền thống Tết. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Tet is the most important holiday in Vietnam. Families celebrate this special time together. Before Tet, people must clean their homes and decorate with flowers and red decorations. This is an important custom and tradition. During Tet, families should visit their relatives and give lucky money to children. Many people watch fireworks in the evening. Tet is a time for reunion. Families prepare traditional food and eat together. Everyone should enjoy this happy holiday with their loved ones.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What must people do before Tet?',
                    'options' => [
                        0 => 'Clean their homes and decorate with flowers',
                        1 => 'Visit all their relatives',
                        2 => 'Watch fireworks',
                        3 => 'Give lucky money to children',
                    ],
                    'answer' => 'Clean their homes and decorate with flowers',
                    'explanation_vi' => 'Đoạn văn nói \'people must clean their homes and decorate with flowers and red decorations.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should families do during Tet?',
                    'options' => [
                        0 => 'Clean their homes',
                        1 => 'Visit their relatives and give lucky money',
                        2 => 'Decorate with flowers',
                        3 => 'Watch fireworks alone',
                    ],
                    'answer' => 'Visit their relatives and give lucky money',
                    'explanation_vi' => 'Đoạn văn nói \'families should visit their relatives and give lucky money to children.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Tet a time for?',
                    'options' => [
                        0 => 'Cleaning only',
                        1 => 'Watching fireworks only',
                        2 => 'Reunion and family time',
                        3 => 'Decorating homes',
                    ],
                    'answer' => 'Reunion and family time',
                    'explanation_vi' => 'Đoạn văn nói \'Tet is a time for reunion\' và \'Families prepare traditional food and eat together.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Tet is the most important holiday in Vietnam.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Câu đầu tiên của đoạn văn nói \'Tet is the most important holiday in Vietnam.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'During Tet, families prepare ___ food and eat together.',
                    'options' => null,
                    'answer' => 'traditional',
                    'explanation_vi' => 'Đoạn văn nói \'Families prepare traditional food and eat together.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Preparing for Tet',
            'title_vi' => 'Chuẩn bị cho Tết',
            'instructions_en' => 'Listen to the conversation about Tet preparations. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về chuẩn bị cho Tết. Sau đó trả lời các câu hỏi.',
            'passage' => 'Mẹ: Hôm nay chúng ta phải chuẩn bị cho Tết. Bạn nên dọn dẹp phòng của bạn.
An: Vâng, mẹ. Bạn nên trang trí nhà cái gì?
Mẹ: Chúng ta nên trang trí với hoa và đồ trang trí truyền thống. Đó là phong tục của chúng ta.
An: Tuyệt vời! Bạn phải thăm người thân không?
Mẹ: Đúng rồi. Chúng ta phải thăm người thân và tặng tiền lì xì cho trẻ em. Đó là truyền thống đặc biệt.
An: Tôi yêu Tết!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should An do today?',
                    'options' => [
                        0 => 'Clean her room',
                        1 => 'Visit relatives',
                        2 => 'Buy fireworks',
                    ],
                    'answer' => 'Clean her room',
                    'explanation_vi' => 'Mẹ nói \'Bạn nên dọn dẹp phòng của bạn\' - An nên dọn dẹp phòng.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should they decorate the house with?',
                    'options' => [
                        0 => 'Fireworks and lights',
                        1 => 'Flowers and traditional decorations',
                        2 => 'Lucky money and gifts',
                    ],
                    'answer' => 'Flowers and traditional decorations',
                    'explanation_vi' => 'Mẹ nói \'Chúng ta nên trang trí với hoa và đồ trang trí truyền thống\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why must they visit relatives?',
                    'options' => [
                        0 => 'Because it is a special tradition',
                        1 => 'Because they live nearby',
                        2 => 'Because they need lucky money',
                    ],
                    'answer' => 'Because it is a special tradition',
                    'explanation_vi' => 'Mẹ nói \'Đó là truyền thống đặc biệt\' - đó là lý do tại sao họ phải thăm người thân.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'An\'s mother says they must give ___ to children during Tet.',
                    'options' => null,
                    'answer' => 'lucky money',
                    'explanation_vi' => 'Mẹ nói \'Chúng ta phải thăm người thân và tặng tiền lì xì cho trẻ em\' - tiền lì xì là đáp án.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'What Should We Do for Tet?',
            'title_vi' => 'Chúng ta nên làm gì cho Tết?',
            'instructions_en' => 'Write about what people should and must do to prepare for and celebrate Tet in Vietnam. Use \'should\' for recommendations and \'must\' for obligations. Write 50-80 words.',
            'instructions_vi' => 'Viết về những gì mọi người nên và phải làm để chuẩn bị và kỷ niệm Tết ở Việt Nam. Dùng \'should\' cho lời khuyên và \'must\' cho bắt buộc. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about Tet preparation and celebration. Include:
- At least two things people should do (use \'should\')
- At least one thing people must do (use \'must\')
- At least one Tet custom or tradition you mention',
            'prompt_vi' => 'Viết về chuẩn bị và kỷ niệm Tết. Bao gồm:
- Ít nhất hai điều mọi người nên làm (dùng \'should\')
- Ít nhất một điều mọi người phải làm (dùng \'must\')
- Ít nhất một phong tục hoặc truyền thống Tết mà bạn đề cập',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-7' => [
        'reading' => [
            'title_en' => 'Minh\'s Television Habits',
            'title_vi' => 'Thói quen xem tivi của Minh',
            'instructions_en' => 'Read the passage about Minh\'s television viewing habits. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về thói quen xem tivi của Minh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh is a Grade 6 student in Hà Nội. He usually watches television every evening. His favourite programmes are cartoons and comedies. He always turns on the television at 7 p.m. and watches for one hour. Minh sometimes watches documentaries because they are interesting and exciting. He never watches news because he thinks it is boring. His habit is to use the remote control to change channels. On weekends, Minh often watches drama programmes with his family. They usually turn off the television at 9 p.m.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What are Minh\'s favourite programmes?',
                    'options' => [
                        0 => 'Cartoons and comedies',
                        1 => 'News and documentaries',
                        2 => 'Drama and news',
                        3 => 'Cartoons and drama',
                    ],
                    'answer' => 'Cartoons and comedies',
                    'explanation_vi' => 'Đoạn văn nói rõ \'His favourite programmes are cartoons and comedies.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Minh never watch news?',
                    'options' => [
                        0 => 'Because it is exciting',
                        1 => 'Because it is boring',
                        2 => 'Because it is interesting',
                        3 => 'Because it is on late',
                    ],
                    'answer' => 'Because it is boring',
                    'explanation_vi' => 'Đoạn văn nói \'He never watches news because he thinks it is boring.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What time does Minh usually turn on the television?',
                    'options' => [
                        0 => '6 p.m.',
                        1 => '8 p.m.',
                        2 => '7 p.m.',
                        3 => '9 p.m.',
                    ],
                    'answer' => '7 p.m.',
                    'explanation_vi' => 'Đoạn văn nói \'He always turns on the television at 7 p.m.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Minh sometimes watches documentaries.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'Minh sometimes watches documentaries because they are interesting and exciting.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'On weekends, Minh often watches ___ programmes with his family.',
                    'options' => null,
                    'answer' => 'drama',
                    'explanation_vi' => 'Đoạn văn nói \'On weekends, Minh often watches drama programmes with his family.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'My Television Habits',
            'title_vi' => 'Thói quen xem tivi của tôi',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! Do you watch television every day?
Minh: Yes, I usually watch television after school. My favourite programme is a cartoon.
Linh: Really? Which cartoon do you like?
Minh: I like Tom and Jerry. It is very funny and exciting. What about you?
Linh: I sometimes watch television. I often watch the news and documentaries. They are interesting.
Minh: That is good! Do you never watch cartoons?
Linh: No, I sometimes watch cartoons too, but I always turn off the television at 9 o\'clock.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'When does Minh usually watch television?',
                    'options' => [
                        0 => 'In the morning',
                        1 => 'After school',
                        2 => 'At night',
                    ],
                    'answer' => 'After school',
                    'explanation_vi' => 'Minh nói \'I usually watch television after school\' (Tôi thường xem tivi sau khi tan học).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Minh\'s favourite programme?',
                    'options' => [
                        0 => 'A documentary',
                        1 => 'A comedy',
                        2 => 'A cartoon',
                    ],
                    'answer' => 'A cartoon',
                    'explanation_vi' => 'Minh nói \'My favourite programme is a cartoon\' (Chương trình yêu thích của tôi là phim hoạt hình).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh think about documentaries?',
                    'options' => [
                        0 => 'They are boring',
                        1 => 'They are interesting',
                        2 => 'They are exciting',
                    ],
                    'answer' => 'They are interesting',
                    'explanation_vi' => 'Linh nói \'I often watch the news and documentaries. They are interesting\' (Tôi thường xem tin tức và phim tài liệu. Chúng thú vị).',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh always turns off the television at ___ o\'clock.',
                    'options' => null,
                    'answer' => '9',
                    'explanation_vi' => 'Linh nói \'I always turn off the television at 9 o\'clock\' (Tôi luôn tắt tivi lúc 9 giờ).',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Television Habits',
            'title_vi' => 'Thói quen xem tivi của tôi',
            'instructions_en' => 'Write about your television watching habits. Use frequency adverbs (always, usually, often, sometimes, never) with the Present Simple tense. Write 50-80 words.',
            'instructions_vi' => 'Viết về thói quen xem tivi của bạn. Sử dụng các trạng từ chỉ tần suất (always, usually, often, sometimes, never) với thì Present Simple. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your television viewing habits. Include:
- What programmes you watch and how often (use frequency adverbs)
- Your favourite type of programme and why you like it
- One programme you never watch and why it is boring or not interesting to you',
            'prompt_vi' => 'Viết về thói quen xem tivi của bạn. Bao gồm:
- Những chương trình bạn xem và bao lâu bạn xem (sử dụng trạng từ chỉ tần suất)
- Loại chương trình yêu thích của bạn và tại sao bạn thích nó
- Một chương trình bạn không bao giờ xem và tại sao nó chán hoặc không thú vị',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-8' => [
        'reading' => [
            'title_en' => 'My Favourite Sports',
            'title_vi' => 'Những môn thể thao yêu thích của tôi',
            'instructions_en' => 'Read the passage about sports. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về thể thao. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Hoa is a student in Hà Nội. She likes many sports. Her favourite sport is swimming. She swims every day and she is very fit and healthy. Her friend Minh plays football. He is a good player and he plays for his school team. Minh and Hoa also like cycling and running. They exercise together three times a week. Minh\'s brother likes badminton and basketball. He plays badminton with his friends on weekends. All of them think sports are very good for their health.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Hoa\'s favourite sport?',
                    'options' => [
                        0 => 'Football',
                        1 => 'Swimming',
                        2 => 'Badminton',
                        3 => 'Cycling',
                    ],
                    'answer' => 'Swimming',
                    'explanation_vi' => 'Đoạn văn nói \'Her favourite sport is swimming.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many times a week do Minh and Hoa exercise together?',
                    'options' => [
                        0 => 'Two times',
                        1 => 'Three times',
                        2 => 'Four times',
                        3 => 'Five times',
                    ],
                    'answer' => 'Three times',
                    'explanation_vi' => 'Đoạn văn nói \'They exercise together three times a week.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What sport does Minh play?',
                    'options' => [
                        0 => 'Swimming',
                        1 => 'Running',
                        2 => 'Football',
                        3 => 'Cycling',
                    ],
                    'answer' => 'Football',
                    'explanation_vi' => 'Đoạn văn nói \'Minh plays football\' và \'he is a good player.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Hoa swims every day.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'She swims every day and she is very fit and healthy.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh plays for his school ___.',
                    'options' => null,
                    'answer' => 'team',
                    'explanation_vi' => 'Đoạn văn nói \'he plays for his school team.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Minh and Linh talk about sports',
            'title_vi' => 'Minh và Linh nói về thể thao',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe hai lần. Sau đó trả lời các câu hỏi.',
            'passage' => 'Minh: Hi Linh! Do you play any sport?
Linh: Yes, I do! I play badminton. It is my favourite game.
Minh: That is great! I like football. I play football with my team every week.
Linh: Do you score many goals?
Minh: Yes, I score three goals last week. What about swimming? Do you like swimming?
Linh: I like swimming too. I exercise every day to stay healthy and fit.
Minh: That is wonderful! You are a good player.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Linh\'s favourite sport?',
                    'options' => [
                        0 => 'football',
                        1 => 'badminton',
                        2 => 'swimming',
                    ],
                    'answer' => 'badminton',
                    'explanation_vi' => 'Linh nói \'I play badminton. It is my favourite game.\' - Cầu lông là trò chơi yêu thích của Linh.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many goals did Minh score last week?',
                    'options' => [
                        0 => 'two goals',
                        1 => 'three goals',
                        2 => 'five goals',
                    ],
                    'answer' => 'three goals',
                    'explanation_vi' => 'Minh nói \'I score three goals last week.\' - Minh ghi được ba bàn tuần trước.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Linh exercise every day?',
                    'options' => [
                        0 => 'to play football',
                        1 => 'to stay healthy and fit',
                        2 => 'to score goals',
                    ],
                    'answer' => 'to stay healthy and fit',
                    'explanation_vi' => 'Linh nói \'I exercise every day to stay healthy and fit.\' - Linh tập thể dục để khỏe mạnh và lành mạnh.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh plays ___ with his team every week.',
                    'options' => null,
                    'answer' => 'football',
                    'explanation_vi' => 'Minh nói \'I play football with my team every week.\' - Minh chơi bóng đá với đội của anh ấy mỗi tuần.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Favourite Sport',
            'title_vi' => 'Môn thể thao yêu thích của tôi',
            'instructions_en' => 'Write about your favourite sport or game. Use Present Simple sentences to describe what you play, why you like it, and how it helps you stay healthy and fit. Write 50-80 words.',
            'instructions_vi' => 'Viết về môn thể thao hoặc trò chơi yêu thích của bạn. Sử dụng các câu Present Simple để mô tả bạn chơi gì, tại sao bạn thích nó, và nó giúp bạn khỏe mạnh như thế nào. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your favourite sport or game. Include:
- The name of the sport or game you play and how often you play it
- Why you like this sport (for example: it is fun, you play with friends, you are a good player)
- How this sport helps you stay healthy and fit',
            'prompt_vi' => 'Viết về môn thể thao hoặc trò chơi yêu thích của bạn. Bao gồm:
- Tên môn thể thao hoặc trò chơi bạn chơi và bạn chơi nó bao lâu một lần
- Tại sao bạn thích môn thể thao này (ví dụ: nó vui, bạn chơi với bạn bè, bạn là một cầu thủ giỏi)
- Môn thể thao này giúp bạn khỏe mạnh và tránh bệnh tật như thế nào',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-9' => [
        'reading' => [
            'title_en' => 'Cities Around the World',
            'title_vi' => 'Các thành phố trên thế giới',
            'instructions_en' => 'Read the passage about two cities. Answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về hai thành phố. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Hà Nội is the capital of Vietnam. It is a large and busy city with a population of about 8 million people. Hà Nội has many ancient landmarks like the Temple of Literature and the Old Quarter. Many tourists visit Hà Nội every year.

Dà Lạt is a smaller city in the mountains. It is more quiet than Hà Nội and more modern in some areas. Dà Lạt has beautiful buildings and natural attractions. The city is not as busy as Hà Nội, but it is very popular with tourists who love nature.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Hà Nội?',
                    'options' => [
                        0 => 'The capital of Vietnam',
                        1 => 'A small city in the mountains',
                        2 => 'A quiet city with ancient landmarks only',
                        3 => 'A city with no tourists',
                    ],
                    'answer' => 'The capital of Vietnam',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Hà Nội is the capital of Vietnam\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How is Dà Lạt different from Hà Nội?',
                    'options' => [
                        0 => 'Dà Lạt is larger and busier',
                        1 => 'Dà Lạt is smaller and more quiet',
                        2 => 'Dà Lạt has more tourists',
                        3 => 'Dà Lạt is the capital of Vietnam',
                    ],
                    'answer' => 'Dà Lạt is smaller and more quiet',
                    'explanation_vi' => 'Đoạn văn nói \'Dà Lạt is a smaller city\' và \'more quiet than Hà Nội\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What attracts tourists to Dà Lạt?',
                    'options' => [
                        0 => 'Only ancient landmarks',
                        1 => 'Only busy streets',
                        2 => 'Beautiful buildings and natural attractions',
                        3 => 'Modern buildings only',
                    ],
                    'answer' => 'Beautiful buildings and natural attractions',
                    'explanation_vi' => 'Đoạn văn nói \'Dà Lạt has beautiful buildings and natural attractions\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Hà Nội has a larger population than Dà Lạt.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Hà Nội có dân số khoảng 8 triệu người và được mô tả là \'large\', còn Dà Lạt là \'smaller city\'.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Dà Lạt is not ___ busy as Hà Nội.',
                    'options' => null,
                    'answer' => 'as',
                    'explanation_vi' => 'Câu so sánh \'as...as\' được dùng: \'The city is not as busy as Hà Nội\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Comparing Cities Around the World',
            'title_vi' => 'So sánh các thành phố trên thế giới',
            'instructions_en' => 'Listen to the conversation about cities. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về các thành phố. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! Do you like big cities or small cities?
Minh: I like big cities. Hanoi is larger than Da Nang. Hanoi is the capital and it has more tourists.
Linh: Yes, but Da Nang is more quiet than Hanoi. Hanoi is very busy.
Minh: That\'s true. But Hanoi has more ancient landmarks. The buildings are very modern too.
Linh: I agree. Hanoi is the most interesting city in Vietnam. Many tourists visit there.
Minh: Yes! Hanoi is as beautiful as Ho Chi Minh City.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which city is larger?',
                    'options' => [
                        0 => 'Da Nang',
                        1 => 'Hanoi',
                        2 => 'Ho Chi Minh City',
                    ],
                    'answer' => 'Hanoi',
                    'explanation_vi' => 'Minh nói \'Hanoi is larger than Da Nang\' - Hà Nội lớn hơn Đà Nẵng.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which city is more quiet?',
                    'options' => [
                        0 => 'Hanoi',
                        1 => 'Da Nang',
                        2 => 'The capital',
                    ],
                    'answer' => 'Da Nang',
                    'explanation_vi' => 'Linh nói \'Da Nang is more quiet than Hanoi\' - Đà Nẵng yên tĩnh hơn Hà Nội.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Hanoi have more of?',
                    'options' => [
                        0 => 'quiet streets',
                        1 => 'ancient landmarks',
                        2 => 'small buildings',
                    ],
                    'answer' => 'ancient landmarks',
                    'explanation_vi' => 'Minh nói \'Hanoi has more ancient landmarks\' - Hà Nội có nhiều địa danh cổ xưa hơn.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Hanoi is ___ interesting city in Vietnam.',
                    'options' => null,
                    'answer' => 'the most',
                    'explanation_vi' => 'Linh nói \'Hanoi is the most interesting city in Vietnam\' - sử dụng tính từ so sánh nhất (superlative).',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Compare Two Vietnamese Cities',
            'title_vi' => 'So sánh Hai Thành Phố Việt Nam',
            'instructions_en' => 'Write 5-8 sentences comparing two Vietnamese cities. Use comparative and superlative adjectives to describe their features. You can choose any two cities you know (for example: Hà Nội and Thành phố Hồ Chí Minh, or Đà Nẵng and Huế).',
            'instructions_vi' => 'Viết 5-8 câu so sánh hai thành phố Việt Nam. Sử dụng tính từ so sánh và tính từ so sánh nhất để mô tả các đặc điểm của chúng. Bạn có thể chọn bất kỳ hai thành phố nào bạn biết (ví dụ: Hà Nội và Thành phố Hồ Chí Minh, hoặc Đà Nẵng và Huế).',
            'passage' => null,
            'prompt_en' => 'Write about two Vietnamese cities. Include:
- The names of the two cities and which one is the capital
- At least two comparisons using \'bigger than\', \'more modern than\', \'busier than\', or similar
- At least one superlative (the biggest, the most ancient, the most famous, etc.)
- Information about landmarks or attractions in each city',
            'prompt_vi' => 'Viết về hai thành phố Việt Nam. Bao gồm:
- Tên của hai thành phố và thành phố nào là thủ đô
- Ít nhất hai so sánh sử dụng \'lớn hơn\', \'hiện đại hơn\', \'nhộn nhịp hơn\', hoặc tương tự
- Ít nhất một tính từ so sánh nhất (lớn nhất, cổ xưa nhất, nổi tiếng nhất, v.v.)
- Thông tin về các địa danh nổi tiếng hoặc điểm thu hút ở mỗi thành phố',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-10' => [
        'reading' => [
            'title_en' => 'Houses in the Future',
            'title_vi' => 'Ngôi nhà tương lai',
            'instructions_en' => 'Read the passage about future houses. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về ngôi nhà tương lai. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'In the future, houses will be very different from today. They will have smart technology in every room. The kitchen will be automatic, and robots will help us cook. The bedroom will be comfortable and warm. Solar panels will give energy to the house. The garden will grow food for the family. We think houses in the future will be amazing!

Many people predict that future houses will save energy and time. Families will not work hard in the kitchen or garden. Smart homes will make life easier and more comfortable. Technology will change how we live.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What will help us cook in the future kitchen?',
                    'options' => [
                        0 => 'Solar panels',
                        1 => 'Robots',
                        2 => 'Smart technology',
                        3 => 'The garden',
                    ],
                    'answer' => 'Robots',
                    'explanation_vi' => 'Đoạn văn nói \'robots will help us cook\' trong phòng bếp tương lai.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What will give energy to future houses?',
                    'options' => [
                        0 => 'The kitchen',
                        1 => 'The bedroom',
                        2 => 'Solar panels',
                        3 => 'The robots',
                    ],
                    'answer' => 'Solar panels',
                    'explanation_vi' => 'Đoạn văn nói \'Solar panels will give energy to the house\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the passage, what will the garden do?',
                    'options' => [
                        0 => 'Be automatic',
                        1 => 'Grow food for the family',
                        2 => 'Give energy',
                        3 => 'Cook meals',
                    ],
                    'answer' => 'Grow food for the family',
                    'explanation_vi' => 'Đoạn văn nói \'The garden will grow food for the family\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Future houses will make families work harder in the kitchen.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'Families will not work hard in the kitchen or garden\' trong tương lai.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Future houses will have ___ technology in every room.',
                    'options' => null,
                    'answer' => 'smart',
                    'explanation_vi' => 'Đoạn văn nói \'They will have smart technology in every room\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Houses in the Future',
            'title_vi' => 'Ngôi nhà tương lai',
            'instructions_en' => 'Listen to the conversation about future houses. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc trò chuyện về ngôi nhà tương lai. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hello Minh! What do you think about houses in the future?
Minh: I think houses will be very smart! They will have technology and robots.
Linh: That sounds great! What about energy?
Minh: Houses will have solar panels. They will use clean energy.
Linh: Will the kitchen be automatic?
Minh: Yes! The kitchen will be automatic. Cooking will be easy and comfortable.
Linh: I predict the bedroom and garden will be beautiful too!
Minh: I agree! Future houses will be amazing!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh think future houses will have?',
                    'options' => [
                        0 => 'Technology and robots',
                        1 => 'Only solar panels',
                        2 => 'A big garden only',
                    ],
                    'answer' => 'Technology and robots',
                    'explanation_vi' => 'Minh nói \'I think houses will be very smart! They will have technology and robots.\' (Minh nghĩ ngôi nhà sẽ rất thông minh! Chúng sẽ có công nghệ và rô-bốt.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What will future houses use for energy?',
                    'options' => [
                        0 => 'Robots only',
                        1 => 'Clean energy from solar panels',
                        2 => 'Technology from the kitchen',
                    ],
                    'answer' => 'Clean energy from solar panels',
                    'explanation_vi' => 'Minh nói \'Houses will have solar panels. They will use clean energy.\' (Ngôi nhà sẽ có tấm pin mặt trời. Chúng sẽ sử dụng năng lượng sạch.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Will the kitchen in future houses be automatic?',
                    'options' => [
                        0 => 'No, it will be difficult',
                        1 => 'Yes, it will be automatic',
                        2 => 'No, only the bedroom will be automatic',
                    ],
                    'answer' => 'Yes, it will be automatic',
                    'explanation_vi' => 'Linh hỏi \'Will the kitchen be automatic?\' và Minh trả lời \'Yes! The kitchen will be automatic.\' (Vâng! Nhà bếp sẽ tự động.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh predicts the bedroom and garden will be ___.',
                    'options' => null,
                    'answer' => 'beautiful',
                    'explanation_vi' => 'Linh nói \'I predict the bedroom and garden will be beautiful too!\' (Tôi dự đoán phòng ngủ và vườn sẽ đẹp lắm!)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My House in the Future',
            'title_vi' => 'Ngôi nhà tương lai của tôi',
            'instructions_en' => 'Write about what your house will be like in the future. Use \'will be\' and \'will have\' to describe your predictions. Write 50-80 words.',
            'instructions_vi' => 'Viết về ngôi nhà tương lai của bạn sẽ như thế nào. Sử dụng \'will be\' và \'will have\' để mô tả những dự đoán của bạn. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your future house. Include:
- What technology or smart things your house will have
- What rooms will be in your house and describe one room
- How your house will be comfortable or different from your house now',
            'prompt_vi' => 'Viết về ngôi nhà tương lai của bạn. Bao gồm:
- Công nghệ hoặc những thứ thông minh mà ngôi nhà của bạn sẽ có
- Những phòng nào sẽ có trong ngôi nhà của bạn và mô tả một phòng
- Ngôi nhà của bạn sẽ thoải mái hoặc khác biệt như thế nào so với ngôi nhà hiện tại',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-11' => [
        'reading' => [
            'title_en' => 'Protecting Our Environment',
            'title_vi' => 'Bảo vệ môi trường của chúng ta',
            'instructions_en' => 'Read the passage about how people protect the environment. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về cách mọi người bảo vệ môi trường. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh and his family want to protect the environment. They recycle plastic bags and waste every day. Minh\'s mother saves water when she washes dishes. His father turns off the lights to save energy. Minh plants trees in the garden with his sister. They reduce pollution by walking to school. The family also reuses old bottles and bags. They believe that small actions make a clean and green world. Everyone can help protect the environment!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh\'s family recycle?',
                    'options' => [
                        0 => 'plastic bags and waste',
                        1 => 'only plastic bags',
                        2 => 'only waste',
                        3 => 'trees and water',
                    ],
                    'answer' => 'plastic bags and waste',
                    'explanation_vi' => 'Đoạn văn nói \'They recycle plastic bags and waste every day.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How does Minh\'s father save energy?',
                    'options' => [
                        0 => 'He walks to school',
                        1 => 'He turns off the lights',
                        2 => 'He plants trees',
                        3 => 'He washes dishes',
                    ],
                    'answer' => 'He turns off the lights',
                    'explanation_vi' => 'Đoạn văn nói \'His father turns off the lights to save energy.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What activity do Minh and his sister do together?',
                    'options' => [
                        0 => 'They recycle waste',
                        1 => 'They turn off lights',
                        2 => 'They plant trees',
                        3 => 'They wash dishes',
                    ],
                    'answer' => 'They plant trees',
                    'explanation_vi' => 'Đoạn văn nói \'Minh plants trees in the garden with his sister.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Minh\'s family reuses old bottles and bags.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'The family also reuses old bottles and bags.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh and his family reduce ___ by walking to school.',
                    'options' => null,
                    'answer' => 'pollution',
                    'explanation_vi' => 'Đoạn văn nói \'They reduce pollution by walking to school.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Protecting Our Environment',
            'title_vi' => 'Bảo vệ môi trường của chúng ta',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! What do you do to protect the environment?
Minh: Hello Linh! I recycle plastic bags and I save water every day.
Linh: That\'s great! Do you turn off the lights?
Minh: Yes, I do. I also reduce waste and reuse old things.
Linh: Wonderful! I plant trees in my garden.
Minh: Excellent! We all protect the environment together.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh do to protect the environment?',
                    'options' => [
                        0 => 'He recycles plastic bags and saves water',
                        1 => 'He plants trees and cleans the house',
                        2 => 'He turns off the lights and plants trees',
                    ],
                    'answer' => 'He recycles plastic bags and saves water',
                    'explanation_vi' => 'Minh nói \'I recycle plastic bags and I save water every day.\' Đó là những gì Minh làm để bảo vệ môi trường.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Does Minh turn off the lights?',
                    'options' => [
                        0 => 'No, he doesn\'t',
                        1 => 'Yes, he does',
                        2 => 'He doesn\'t say',
                    ],
                    'answer' => 'Yes, he does',
                    'explanation_vi' => 'Khi Linh hỏi \'Do you turn off the lights?\', Minh trả lời \'Yes, I do.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh do to protect the environment?',
                    'options' => [
                        0 => 'She saves water and recycles plastic',
                        1 => 'She plants trees in her garden',
                        2 => 'She turns off the lights and reduces waste',
                    ],
                    'answer' => 'She plants trees in her garden',
                    'explanation_vi' => 'Linh nói \'I plant trees in my garden.\' Đó là cách Linh bảo vệ môi trường.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh also reduces ___ and reuses old things.',
                    'options' => null,
                    'answer' => 'waste',
                    'explanation_vi' => 'Minh nói \'I also reduce waste and reuse old things.\' Từ còn thiếu là \'waste\' (rác thải).',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Green Habits',
            'title_vi' => 'Những thói quen xanh của tôi',
            'instructions_en' => 'Write about 3 things you do every day or every week to protect the environment. Use simple present tense (I recycle..., We save..., She plants...). Write 50-80 words.',
            'instructions_vi' => 'Viết về 3 điều bạn làm mỗi ngày hoặc mỗi tuần để bảo vệ môi trường. Sử dụng thì hiện tại đơn (I recycle..., We save..., She plants...). Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your green habits. Include:
- One habit about reducing waste or recycling plastic
- One habit about saving water or energy
- One habit about protecting nature (planting trees, keeping places clean, etc.)',
            'prompt_vi' => 'Viết về những thói quen xanh của bạn. Bao gồm:
- Một thói quen về giảm rác thải hoặc tái chế nhựa
- Một thói quen về tiết kiệm nước hoặc năng lượng
- Một thói quen về bảo vệ thiên nhiên (trồng cây, giữ nơi sạch sẽ, v.v.)',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '6-12' => [
        'reading' => [
            'title_en' => 'Robots and Their Abilities',
            'title_vi' => 'Người máy và khả năng của họ',
            'instructions_en' => 'Read the passage about robots. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về người máy. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Robots are intelligent machines. They can do many useful things. A robot can clean the house and cook food very fast. Robots can help people with dangerous work. They are very strong and work all day without stopping.

However, robots cannot think like people. They cannot feel happy or sad. Robots can only do what people teach them to do. In the future, robots will help us more and more in our homes and at work.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What can robots do according to the passage?',
                    'options' => [
                        0 => 'They can clean the house and cook food very fast',
                        1 => 'They can think like people',
                        2 => 'They can feel happy and sad',
                        3 => 'They can teach people new things',
                    ],
                    'answer' => 'They can clean the house and cook food very fast',
                    'explanation_vi' => 'Đoạn văn nói rõ \'A robot can clean the house and cook food very fast.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why are robots useful for dangerous work?',
                    'options' => [
                        0 => 'Because they are intelligent',
                        1 => 'Because they can think like people',
                        2 => 'Because they are very strong and can help people with dangerous work',
                        3 => 'Because they can feel emotions',
                    ],
                    'answer' => 'Because they are very strong and can help people with dangerous work',
                    'explanation_vi' => 'Đoạn văn nói \'Robots can help people with dangerous work. They are very strong.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is one thing robots cannot do?',
                    'options' => [
                        0 => 'They cannot work fast',
                        1 => 'They cannot think like people',
                        2 => 'They cannot clean houses',
                        3 => 'They cannot help with work',
                    ],
                    'answer' => 'They cannot think like people',
                    'explanation_vi' => 'Đoạn văn nói rõ \'However, robots cannot think like people.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Robots can feel happy and sad like humans.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'They cannot feel happy or sad.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Robots are ___ machines that can do many useful things.',
                    'options' => null,
                    'answer' => 'intelligent',
                    'explanation_vi' => 'Câu đầu tiên của đoạn văn là \'Robots are intelligent machines.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Robots in the Future',
            'title_vi' => 'Người máy trong tương lai',
            'instructions_en' => 'Listen to the conversation about robots. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về người máy. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hello Minh! Do you like robots?
Minh: Yes, I do! Robots are very useful machines.
Linh: What can robots do?
Minh: They can clean houses and cook food. They can work very fast and they are very strong.
Linh: Can robots think?
Minh: No, they cannot think. Robots cannot feel. But they are intelligent machines.
Linh: Are robots dangerous?
Minh: No, robots can help us. They are not dangerous.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What can robots do?',
                    'options' => [
                        0 => 'They can clean houses and cook food',
                        1 => 'They can think and feel',
                        2 => 'They can play football',
                    ],
                    'answer' => 'They can clean houses and cook food',
                    'explanation_vi' => 'Trong cuộc hội thoại, Minh nói \'They can clean houses and cook food\' (Họ có thể dọn dẹp nhà và nấu ăn).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Can robots think?',
                    'options' => [
                        0 => 'Yes, robots can think',
                        1 => 'No, robots cannot think',
                        2 => 'Robots can think very fast',
                    ],
                    'answer' => 'No, robots cannot think',
                    'explanation_vi' => 'Minh trả lời \'No, they cannot think\' (Không, họ không thể suy nghĩ).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Are robots dangerous?',
                    'options' => [
                        0 => 'Yes, robots are very dangerous',
                        1 => 'No, robots can help us and are not dangerous',
                        2 => 'Robots are dangerous machines',
                    ],
                    'answer' => 'No, robots can help us and are not dangerous',
                    'explanation_vi' => 'Minh nói \'No, robots can help us. They are not dangerous\' (Không, người máy có thể giúp chúng ta. Họ không nguy hiểm).',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Robots are very ___ machines.',
                    'options' => null,
                    'answer' => 'useful',
                    'explanation_vi' => 'Minh nói \'Robots are very useful machines\' (Người máy là những máy rất hữu ích).',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'What Can Robots Do?',
            'title_vi' => 'Người máy có thể làm gì?',
            'instructions_en' => 'Write about a robot and what it can or cannot do. Use the grammar structure \'can/cannot + base verb\' to describe the robot\'s abilities. Write 50-80 words.',
            'instructions_vi' => 'Viết về một người máy và những gì nó có thể hoặc không thể làm. Sử dụng cấu trúc ngữ pháp \'can/cannot + động từ nguyên mẫu\' để mô tả khả năng của người máy. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Imagine a robot that helps people at home in Hà Nội. Write about:
- What the robot can do (use at least 2 abilities with \'can\')
- What the robot cannot do (use at least 1 ability with \'cannot\')
- Why this robot is useful or dangerous',
            'prompt_vi' => 'Hãy tưởng tượng một người máy giúp đỡ mọi người ở nhà ở Hà Nội. Viết về:
- Những gì người máy có thể làm (sử dụng ít nhất 2 khả năng với \'can\')
- Những gì người máy không thể làm (sử dụng ít nhất 1 khả năng với \'cannot\')
- Tại sao người máy này hữu ích hoặc nguy hiểm',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-1' => [
        'reading' => [
            'title_en' => 'My Friends\' Hobbies',
            'title_vi' => 'Sở thích của các bạn tôi',
            'instructions_en' => 'Read the passage about three friends and their hobbies. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về sở thích của ba bạn. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh loves reading because it is very interesting. She reads books every day. Her reason for enjoying reading is that books help her learn new things.

Mai likes playing sports and swimming. She enjoys these activities because they are fun and relaxing. Mai plays badminton three times a week. Hùng loves listening to music and dancing. He enjoys dancing because it makes him happy. Hùng also likes cooking traditional Vietnamese food for his family.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Linh love reading?',
                    'options' => [
                        0 => 'Because it is very interesting',
                        1 => 'Because it is fun and relaxing',
                        2 => 'Because it makes her happy',
                        3 => 'Because she likes cooking',
                    ],
                    'answer' => 'Because it is very interesting',
                    'explanation_vi' => 'Đoạn văn nói \'Linh loves reading because it is very interesting.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Mai enjoy doing?',
                    'options' => [
                        0 => 'Reading and cooking',
                        1 => 'Playing sports and swimming',
                        2 => 'Listening to music and dancing',
                        3 => 'Reading and dancing',
                    ],
                    'answer' => 'Playing sports and swimming',
                    'explanation_vi' => 'Đoạn văn nói \'Mai likes playing sports and swimming.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How often does Mai play badminton?',
                    'options' => [
                        0 => 'Every day',
                        1 => 'Two times a week',
                        2 => 'Three times a week',
                        3 => 'Once a week',
                    ],
                    'answer' => 'Three times a week',
                    'explanation_vi' => 'Đoạn văn nói \'Mai plays badminton three times a week.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Hùng enjoys listening to music and dancing.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'Hùng loves listening to music and dancing.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Hùng likes cooking traditional Vietnamese ___ for his family.',
                    'options' => null,
                    'answer' => 'food',
                    'explanation_vi' => 'Từ \'food\' hoàn thành câu từ đoạn văn: \'Hùng also likes cooking traditional Vietnamese food for his family.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'My Hobbies',
            'title_vi' => 'Sở thích của tôi',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe nó hai lần. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! What is your hobby?
Minh: I love playing sports because it is fun. I enjoy swimming and playing football.
Linh: That\'s great! I like reading. Reading is very interesting and relaxing.
Minh: Do you like listening to music too?
Linh: Yes, I do! I love listening to music because it helps me relax. What about dancing?
Minh: I enjoy dancing! It is fun and interesting.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh love doing?',
                    'options' => [
                        0 => 'Reading and listening to music',
                        1 => 'Playing sports and dancing',
                        2 => 'Cooking and swimming',
                    ],
                    'answer' => 'Playing sports and dancing',
                    'explanation_vi' => 'Minh nói \'I love playing sports\' và \'I enjoy dancing\'. Đó là những sở thích của Minh.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Linh like reading?',
                    'options' => [
                        0 => 'Because it is fun and relaxing',
                        1 => 'Because it is interesting and relaxing',
                        2 => 'Because it helps her relax',
                    ],
                    'answer' => 'Because it is interesting and relaxing',
                    'explanation_vi' => 'Linh nói \'Reading is very interesting and relaxing.\' Đó là lý do tại sao cô ấy thích đọc sách.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh enjoy listening to?',
                    'options' => [
                        0 => 'Sports and dancing',
                        1 => 'Music and reading',
                        2 => 'Music',
                    ],
                    'answer' => 'Music',
                    'explanation_vi' => 'Linh nói \'I love listening to music\'. Cô ấy thích nghe nhạc.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh enjoys ___ because it is fun and interesting.',
                    'options' => null,
                    'answer' => 'dancing',
                    'explanation_vi' => 'Minh nói \'I enjoy dancing! It is fun and interesting.\' Từ cần điền là \'dancing\'.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Write about Your Hobby',
            'title_vi' => 'Viết về Sở Thích của Bạn',
            'instructions_en' => 'Write a short paragraph about one of your hobbies. Use the present simple with \'like\', \'love\', or \'enjoy\' + -ing. Explain why you like this hobby. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn về một sở thích của bạn. Sử dụng thì hiện tại đơn với \'like\', \'love\', hoặc \'enjoy\' + -ing. Giải thích tại sao bạn thích sở thích này. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your hobby. Include:
- What hobby you like, love, or enjoy (use -ing form)
- Why you like it (use \'because\' + an adjective like interesting, relaxing, or fun)
- One more detail about when or how you do this hobby',
            'prompt_vi' => 'Viết về sở thích của bạn. Bao gồm:
- Sở thích nào bạn thích, yêu thích, hoặc thích (sử dụng dạng -ing)
- Tại sao bạn thích nó (sử dụng \'because\' + một tính từ như interesting, relaxing, hoặc fun)
- Một chi tiết khác về khi nào hoặc cách bạn làm sở thích này',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-2' => [
        'reading' => [
            'title_en' => 'Minh\'s Healthy Habits',
            'title_vi' => 'Những thói quen khoẻ mạnh của Minh',
            'instructions_en' => 'Read the passage about Minh\'s healthy lifestyle. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về lối sống khoẻ mạnh của Minh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh is a 12-year-old student in Hà Nội. He wants to have a healthy life. Every day, he ought to exercise for 30 minutes. He plays football with his friends after school. Minh should eat a good diet with lots of vegetables and fruit. He must avoid eating too much candy and fast food. He also sleeps eight hours every night because good sleep is important for his health.

Last week, Minh had a fever and a headache. He started to cough too. His mother took him to see a doctor. The doctor gave him medicine and said, "You must rest and drink warm water." Now Minh feels better. He knows that good habits help him avoid illness and disease.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How long does Minh exercise every day?',
                    'options' => [
                        0 => '20 minutes',
                        1 => '30 minutes',
                        2 => '40 minutes',
                        3 => '50 minutes',
                    ],
                    'answer' => '30 minutes',
                    'explanation_vi' => 'Đoạn văn nói rõ \'he ought to exercise for 30 minutes\' (anh ấy nên tập thể dục 30 phút).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What symptoms did Minh have last week?',
                    'options' => [
                        0 => 'Headache and cough only',
                        1 => 'Fever, headache, and cough',
                        2 => 'Fever and cough only',
                        3 => 'Fever only',
                    ],
                    'answer' => 'Fever, headache, and cough',
                    'explanation_vi' => 'Đoạn văn liệt kê ba triệu chứng: \'fever and a headache\' và \'He started to cough too\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should Minh avoid eating?',
                    'options' => [
                        0 => 'Vegetables and fruit',
                        1 => 'Candy and fast food',
                        2 => 'Medicine and water',
                        3 => 'Fish and rice',
                    ],
                    'answer' => 'Candy and fast food',
                    'explanation_vi' => 'Đoạn văn nói \'He must avoid eating too much candy and fast food\' (anh ấy phải tránh ăn quá nhiều kẹo và thức ăn nhanh).',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Minh sleeps six hours every night.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'He also sleeps eight hours every night\' (anh ấy ngủ tám tiếng mỗi đêm), không phải sáu tiếng.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh\'s mother took him to see a ___ because he had a fever and a cough.',
                    'options' => null,
                    'answer' => 'doctor',
                    'explanation_vi' => 'Đoạn văn nói \'His mother took him to see a doctor\' (mẹ anh ấy đưa anh ấy đi gặp bác sĩ).',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Healthy Living Advice',
            'title_vi' => 'Lời khuyên về sống khoẻ mạnh',
            'instructions_en' => 'Listen to the conversation between Minh and his doctor. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc trò chuyện giữa Minh và bác sĩ của anh ấy. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Doctor: Hello Minh. How are you today?
Minh: I have a headache and a cough, doctor.
Doctor: I see. You should see me about your symptoms. Do you have a fever?
Minh: Yes, I have a small fever.
Doctor: You must rest and sleep more. You ought to avoid cold food and drink hot water.
Minh: What about exercise, doctor?
Doctor: You should not exercise now. You must take this medicine and eat healthy food.
Minh: Thank you, doctor. I will follow your advice.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What symptoms does Minh have?',
                    'options' => [
                        0 => 'A headache and a cough',
                        1 => 'A fever and a cough only',
                        2 => 'A headache only',
                    ],
                    'answer' => 'A headache and a cough',
                    'explanation_vi' => 'Minh nói: \'I have a headache and a cough, doctor.\' (Tôi bị đau đầu và ho, bác sĩ.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does the doctor say Minh should NOT do?',
                    'options' => [
                        0 => 'Sleep more',
                        1 => 'Exercise',
                        2 => 'Drink hot water',
                    ],
                    'answer' => 'Exercise',
                    'explanation_vi' => 'Bác sĩ nói: \'You should not exercise now.\' (Bây giờ bạn không nên tập thể dục.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What must Minh do according to the doctor?',
                    'options' => [
                        0 => 'Eat cold food and drink cold water',
                        1 => 'Rest, sleep more, and take medicine',
                        2 => 'Exercise every day',
                    ],
                    'answer' => 'Rest, sleep more, and take medicine',
                    'explanation_vi' => 'Bác sĩ nói: \'You must rest and sleep more\' và \'You must take this medicine.\' (Bạn phải nghỉ ngơi và ngủ nhiều hơn, và bạn phải uống thuốc này.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'You ought to avoid ___ food and drink hot water.',
                    'options' => null,
                    'answer' => 'cold',
                    'explanation_vi' => 'Bác sĩ nói: \'You ought to avoid cold food and drink hot water.\' (Bạn nên tránh thức ăn lạnh và uống nước nóng.)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Give Health Advice to a Friend',
            'title_vi' => 'Đưa ra lời khuyên về sức khỏe cho bạn',
            'instructions_en' => 'Write a short message to a friend who is not feeling well. Use modal verbs (should, must, ought to) to give advice about staying healthy. Write 50-80 words.',
            'instructions_vi' => 'Viết một tin nhắn ngắn cho bạn của bạn người đang không cảm thấy khoẻ. Sử dụng các động từ khuyết thiếu (should, must, ought to) để đưa ra lời khuyên về sức khỏe. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Your friend Linh has a cough, headache, and fever. Write a message giving her health advice. Include:
- What symptoms she has and what she should do about them
- What healthy habits she must follow (exercise, diet, sleep)
- What she ought to avoid to get better',
            'prompt_vi' => 'Bạn của bạn là Linh bị ho, đau đầu và sốt. Viết một tin nhắn đưa ra lời khuyên về sức khỏe cho cô ấy. Bao gồm:
- Những triệu chứng cô ấy có và cô ấy nên làm gì
- Những thói quen khoẻ mạnh cô ấy phải tuân theo (tập thể dục, chế độ ăn, ngủ)
- Những gì cô ấy nên tránh để khỏi bệnh',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-3' => [
        'reading' => [
            'title_en' => 'Volunteers in Our Community',
            'title_vi' => 'Những tình nguyện viên trong cộng đồng của chúng ta',
            'instructions_en' => 'Read the passage about community service. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về hoạt động vì cộng đồng. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh and her friends are volunteers in Hà Nội. Every Saturday, they organize activities to help their neighborhood. They clean up the streets and parks in their community. They also care for elderly people in the local charity center. The volunteers donate food and clothes to families in need. Linh believes that volunteers make a difference in the environment and society. She thinks young people should participate in community service. Her friends ought to help the elderly more often. Through these activities, Linh and her team support their community and make it a better place.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What do Linh and her friends do every Saturday?',
                    'options' => [
                        0 => 'They organize activities to help their neighborhood',
                        1 => 'They donate money to schools',
                        2 => 'They teach English in the community center',
                        3 => 'They play sports in the park',
                    ],
                    'answer' => 'They organize activities to help their neighborhood',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Every Saturday, they organize activities to help their neighborhood.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which of the following is NOT mentioned as a volunteer activity?',
                    'options' => [
                        0 => 'Cleaning up streets and parks',
                        1 => 'Caring for elderly people',
                        2 => 'Donating food and clothes',
                        3 => 'Building new houses',
                    ],
                    'answer' => 'Building new houses',
                    'explanation_vi' => 'Đoạn văn không đề cập đến xây dựng nhà mới, chỉ nói về dọn dẹp, chăm sóc người cao tuổi, và quyên góp.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh think young people should do?',
                    'options' => [
                        0 => 'They should study harder',
                        1 => 'They should participate in community service',
                        2 => 'They should work in charity centers',
                        3 => 'They should donate all their money',
                    ],
                    'answer' => 'They should participate in community service',
                    'explanation_vi' => 'Đoạn văn nói \'She thinks young people should participate in community service.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Linh and her friends care for elderly people at the local charity center.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói rõ \'They also care for elderly people in the local charity center.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh believes that volunteers ___ in the environment and society.',
                    'options' => null,
                    'answer' => 'make a difference',
                    'explanation_vi' => 'Câu trong đoạn văn là \'Linh believes that volunteers make a difference in the environment and society.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Community Service in Our Neighborhood',
            'title_vi' => 'Hoạt động vì cộng đồng trong khu phố của chúng ta',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! Do you volunteer in our community?
Minh: Yes, I do. I volunteer every Saturday. I help clean up the neighborhood park.
Linh: That\'s great! What else do you do?
Minh: I also care for elderly people at the community center. I visit them and we talk together.
Linh: That sounds wonderful. Should I volunteer too?
Minh: Yes, you should! We need more volunteers. You can help make a difference in our community.
Linh: OK! I want to participate. What activity should I do?
Minh: You could donate to a local charity, or you could help organize a community service event.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'When does Minh volunteer?',
                    'options' => [
                        0 => 'Every Sunday',
                        1 => 'Every Saturday',
                        2 => 'Every Friday',
                    ],
                    'answer' => 'Every Saturday',
                    'explanation_vi' => 'Minh nói \'I volunteer every Saturday\' (Tôi tình nguyện mỗi thứ bảy).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh do at the community center?',
                    'options' => [
                        0 => 'He cleans up the park',
                        1 => 'He cares for elderly people',
                        2 => 'He donates money',
                    ],
                    'answer' => 'He cares for elderly people',
                    'explanation_vi' => 'Minh nói \'I also care for elderly people at the community center\' (Tôi cũng chăm sóc người cao tuổi tại trung tâm cộng đồng).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Minh think Linh should volunteer?',
                    'options' => [
                        0 => 'Because it is easy',
                        1 => 'Because they need more volunteers',
                        2 => 'Because it is fun on Saturday',
                    ],
                    'answer' => 'Because they need more volunteers',
                    'explanation_vi' => 'Minh nói \'We need more volunteers\' (Chúng ta cần thêm tình nguyện viên).',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh helps clean up the neighborhood ___.',
                    'options' => null,
                    'answer' => 'park',
                    'explanation_vi' => 'Minh nói \'I help clean up the neighborhood park\' (Tôi giúp dọn dẹp công viên khu phố).',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Writing about Your Community Service Plan',
            'title_vi' => 'Viết về kế hoạch hoạt động vì cộng đồng của bạn',
            'instructions_en' => 'Write a short paragraph (50-80 words) about a community service activity you want to volunteer for. Use the Present Simple to describe what volunteers do, and use \'should\' or \'ought to\' to give one suggestion about helping your community.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) về một hoạt động vì cộng đồng mà bạn muốn tình nguyện. Sử dụng Present Simple để mô tả những gì những tình nguyện viên làm, và sử dụng \'should\' hoặc \'ought to\' để đưa ra một gợi ý về giúp đỡ cộng đồng của bạn.',
            'passage' => null,
            'prompt_en' => 'Write about a community service activity in your neighborhood. Include:
- What activity you want to volunteer for (for example: clean up the environment, care for elderly people, donate to charity, or organize an activity)
- What volunteers do in this activity (use Present Simple: \'Volunteers help...\', \'They participate in...\')
- One suggestion using \'should\' or \'ought to\' about why people should support this service or how it can make a difference',
            'prompt_vi' => 'Viết về một hoạt động vì cộng đồng ở khu phố của bạn. Bao gồm:
- Hoạt động nào bạn muốn tình nguyện (ví dụ: dọn dẹp môi trường, chăm sóc người cao tuổi, quyên góp cho tổ chức từ thiện, hoặc tổ chức một hoạt động)
- Những gì những tình nguyện viên làm trong hoạt động này (sử dụng Present Simple: \'Volunteers help...\', \'They participate in...\')
- Một gợi ý sử dụng \'should\' hoặc \'ought to\' về lý do tại sao mọi người nên hỗ trợ dịch vụ này hoặc cách nó có thể tạo ra sự thay đổi',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-4' => [
        'reading' => [
            'title_en' => 'Linh\'s Love for Music',
            'title_vi' => 'Tình yêu âm nhạc của Linh',
            'instructions_en' => 'Read the passage about Linh and her favorite music. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về Linh và âm nhạc yêu thích của cô ấy. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh is a talented artist from Hà Nội. She enjoys playing the guitar and the piano. Her favorite instrument is the guitar because she loves playing modern songs. Linh\'s best friend Minh likes classical music. Minh enjoys playing the violin and performing at concerts. Last month, Linh and Minh went to a concert together. They watched a famous singer perform beautiful songs. Both girls enjoy listening to music and they want to be professional musicians in the future.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Linh\'s favorite instrument?',
                    'options' => [
                        0 => 'the guitar',
                        1 => 'the piano',
                        2 => 'the violin',
                        3 => 'the drum',
                    ],
                    'answer' => 'the guitar',
                    'explanation_vi' => 'Đoạn văn nói \'Her favorite instrument is the guitar\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What type of music does Minh enjoy?',
                    'options' => [
                        0 => 'modern music',
                        1 => 'classical music',
                        2 => 'pop music',
                        3 => 'rock music',
                    ],
                    'answer' => 'classical music',
                    'explanation_vi' => 'Đoạn văn nói \'Minh likes classical music\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What did Linh and Minh do last month?',
                    'options' => [
                        0 => 'They played guitar together',
                        1 => 'They performed at a concert',
                        2 => 'They went to a concert together',
                        3 => 'They bought new instruments',
                    ],
                    'answer' => 'They went to a concert together',
                    'explanation_vi' => 'Đoạn văn nói \'Last month, Linh and Minh went to a concert together\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Linh enjoys playing the violin.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói Linh chơi guitar và piano, không phải violin. Minh chơi violin.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh enjoys playing ___ and the piano.',
                    'options' => null,
                    'answer' => 'the guitar',
                    'explanation_vi' => 'Đoạn văn nói \'She enjoys playing the guitar and the piano\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Linh\'s Favorite Music',
            'title_vi' => 'Âm nhạc yêu thích của Linh',
            'instructions_en' => 'Listen to the conversation between Linh and her friend Minh. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc trò chuyện giữa Linh và bạn của cô ấy là Minh. Sau đó trả lời các câu hỏi.',
            'passage' => 'Minh: Hi Linh! Do you like music?
Linh: Yes, I do! I enjoy listening to modern songs. My favorite singer is Mỹ Tâm.
Minh: That\'s great! Do you play any instruments?
Linh: Yes, I play the guitar. I enjoy playing guitar very much.
Minh: Wow! Are you talented?
Linh: Thank you! I want to perform at a concert one day.
Minh: That\'s wonderful! I like classical music. I play the piano.
Linh: That\'s amazing! We both love music!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Linh\'s favorite type of music?',
                    'options' => [
                        0 => 'classical music',
                        1 => 'modern songs',
                        2 => 'traditional music',
                    ],
                    'answer' => 'modern songs',
                    'explanation_vi' => 'Linh nói \'I enjoy listening to modern songs\' - cô ấy thích nghe những bài hát hiện đại.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What instrument does Minh play?',
                    'options' => [
                        0 => 'guitar',
                        1 => 'violin',
                        2 => 'piano',
                    ],
                    'answer' => 'piano',
                    'explanation_vi' => 'Minh nói \'I play the piano\' - Minh chơi đàn piano.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh want to do one day?',
                    'options' => [
                        0 => 'listen to a concert',
                        1 => 'perform at a concert',
                        2 => 'teach music',
                    ],
                    'answer' => 'perform at a concert',
                    'explanation_vi' => 'Linh nói \'I want to perform at a concert one day\' - cô ấy muốn biểu diễn tại một buổi hòa nhạc.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh enjoys playing the ___ very much.',
                    'options' => null,
                    'answer' => 'guitar',
                    'explanation_vi' => 'Linh nói \'I enjoy playing guitar very much\' - cô ấy thích chơi đàn guitar rất nhiều.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Favorite Music and Artists',
            'title_vi' => 'Âm nhạc và nghệ sĩ yêu thích của tôi',
            'instructions_en' => 'Write about your favorite music and the artists or instruments you like. Use \'like\' or \'enjoy\' with nouns or -ing forms to describe your preferences. Write 50-80 words.',
            'instructions_vi' => 'Viết về âm nhạc yêu thích của bạn và những nghệ sĩ hoặc nhạc cụ mà bạn thích. Sử dụng \'like\' hoặc \'enjoy\' với danh từ hoặc dạng -ing để mô tả sở thích của bạn. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write a short paragraph about your music preferences. Include:
- What type of music you like or enjoy (classical, modern, or both)
- Your favorite instrument or singer/artist
- Why you enjoy listening to music or watching concerts',
            'prompt_vi' => 'Viết một đoạn văn ngắn về sở thích âm nhạc của bạn. Bao gồm:
- Loại âm nhạc bạn thích (cổ điển, hiện đại, hoặc cả hai)
- Nhạc cụ hoặc ca sĩ/nghệ sĩ yêu thích của bạn
- Tại sao bạn thích nghe nhạc hoặc xem buổi hòa nhạc',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-5' => [
        'reading' => [
            'title_en' => 'Linh\'s Favorite Dish',
            'title_vi' => 'Món ăn yêu thích của Linh',
            'instructions_en' => 'Read the passage about Linh\'s cooking. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về nấu ăn của Linh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh is twelve years old and she loves to cook. Her favorite dish is spring rolls. The ingredients are fresh vegetables, pork, and rice paper. First, she prepares the vegetables and mixes them with pork. Then, she boils water and puts the rice paper in it. After that, she wraps the ingredients in the rice paper. Finally, she fries the spring rolls in oil until they are golden. The spring rolls are delicious and not too spicy. Linh\'s mother would like to eat them every week. Her friends also recommend this dish to other people.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Linh\'s favorite dish?',
                    'options' => [
                        0 => 'Spring rolls',
                        1 => 'Fried chicken',
                        2 => 'Baked fish',
                        3 => 'Boiled vegetables',
                    ],
                    'answer' => 'Spring rolls',
                    'explanation_vi' => 'Đoạn văn nói \'Her favorite dish is spring rolls.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which ingredient is NOT mentioned in the recipe?',
                    'options' => [
                        0 => 'Rice paper',
                        1 => 'Fresh vegetables',
                        2 => 'Pork',
                        3 => 'Chicken',
                    ],
                    'answer' => 'Chicken',
                    'explanation_vi' => 'Các nguyên liệu được đề cập là rau tươi, thịt lợn, và giấy gạo. Gà không được nhắc đến.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How does Linh cook the spring rolls?',
                    'options' => [
                        0 => 'She boils them',
                        1 => 'She bakes them',
                        2 => 'She fries them',
                        3 => 'She mixes them',
                    ],
                    'answer' => 'She fries them',
                    'explanation_vi' => 'Đoạn văn nói \'she fries the spring rolls in oil.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Linh\'s spring rolls are very spicy.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'The spring rolls are delicious and not too spicy.\' (không quá cay)',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh ___ the vegetables and mixes them with pork.',
                    'options' => null,
                    'answer' => 'prepares',
                    'explanation_vi' => 'Câu trong đoạn văn là \'First, she prepares the vegetables and mixes them with pork.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'At Quán Cơm Tấm',
            'title_vi' => 'Ở Quán Cơm Tấm',
            'instructions_en' => 'Listen to the conversation between Linh and the restaurant owner. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại giữa Linh và chủ quán. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Good morning! I would like to order a dish. What do you recommend?
Owner: Hello! Our cơm tấm is very delicious. The ingredients are fresh. We fry the fish and mix it with rice.
Linh: That sounds good. Is it spicy?
Owner: No, it is not spicy. It is a little salty and sweet.
Linh: Perfect! I would like one cơm tấm, please.
Owner: Great! We will prepare it for you now.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What dish does the owner recommend?',
                    'options' => [
                        0 => 'Bún chả',
                        1 => 'Cơm tấm',
                        2 => 'Phở',
                    ],
                    'answer' => 'Cơm tấm',
                    'explanation_vi' => 'Chủ quán nói \'Our cơm tấm is very delicious\' - Cơm tấm của chúng tôi rất ngon.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How does the owner prepare the fish?',
                    'options' => [
                        0 => 'Boil it',
                        1 => 'Fry it',
                        2 => 'Bake it',
                    ],
                    'answer' => 'Fry it',
                    'explanation_vi' => 'Chủ quán nói \'We fry the fish\' - Chúng tôi rán cá.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Is the cơm tấm spicy?',
                    'options' => [
                        0 => 'Yes, it is very spicy',
                        1 => 'No, it is not spicy',
                        2 => 'Yes, a little spicy',
                    ],
                    'answer' => 'No, it is not spicy',
                    'explanation_vi' => 'Chủ quán trả lời \'No, it is not spicy\' - Không, nó không cay.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh would like one cơm tấm. The ingredients are ___.',
                    'options' => null,
                    'answer' => 'fresh',
                    'explanation_vi' => 'Chủ quán nói \'The ingredients are fresh\' - Nguyên liệu tươi.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Writing a Polite Food Request',
            'title_vi' => 'Viết một yêu cầu đồ ăn lịch sự',
            'instructions_en' => 'Write a short conversation between you and a waiter at a Vietnamese restaurant. Use \'would like\' to make polite requests about food. Describe the dish you want and ask about ingredients or how it is prepared.',
            'instructions_vi' => 'Viết một đoạn hội thoại ngắn giữa bạn và một nhân viên phục vụ tại một nhà hàng Việt Nam. Sử dụng \'would like\' để yêu cầu đồ ăn một cách lịch sự. Mô tả món ăn bạn muốn và hỏi về nguyên liệu hoặc cách chuẩn bị.',
            'passage' => null,
            'prompt_en' => 'Write a conversation (at least 50 words) between you and a waiter. Include:
- What dish you would like to order
- Questions about the ingredients or how the dish is prepared (cooked, fried, boiled, baked, etc.)
- A description of the dish using adjectives (delicious, fresh, spicy, salty, sweet)',
            'prompt_vi' => 'Viết một đoạn hội thoại (ít nhất 50 từ) giữa bạn và nhân viên phục vụ. Bao gồm:
- Món ăn bạn muốn gọi
- Câu hỏi về nguyên liệu hoặc cách chuẩn bị món ăn (nấu, rán, đun sôi, nướng, v.v.)
- Mô tả món ăn bằng các tính từ (ngon, tươi, cay, mặn, ngọt)',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-6' => [
        'reading' => [
            'title_en' => 'A Visit to Thang Long School',
            'title_vi' => 'Tham quan Trường Thăng Long',
            'instructions_en' => 'Read the passage about Minh\'s visit to Thang Long School. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về chuyến tham quan trường Thăng Long của Minh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Last week, Minh visited Thang Long School in Hà Nội. The school is very modern and beautiful. The classrooms are as bright as the library. The playground is more spacious than the old playground at Minh\'s school. The laboratory is very different from traditional schools. Students wear blue and white uniforms. They study many subjects like Maths, English, and Science. The buildings are similar to other modern schools in the city. Minh thinks Thang Long School is more interesting than his own school.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What color are the uniforms at Thang Long School?',
                    'options' => [
                        0 => 'Blue and white',
                        1 => 'Red and white',
                        2 => 'Green and yellow',
                        3 => 'Black and white',
                    ],
                    'answer' => 'Blue and white',
                    'explanation_vi' => 'Đoạn văn nói \'Students wear blue and white uniforms.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How is the playground at Thang Long School compared to Minh\'s old playground?',
                    'options' => [
                        0 => 'It is smaller',
                        1 => 'It is more spacious',
                        2 => 'It is the same size',
                        3 => 'It is older',
                    ],
                    'answer' => 'It is more spacious',
                    'explanation_vi' => 'Đoạn văn nói \'The playground is more spacious than the old playground at Minh\'s school.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which statement about Thang Long School is true?',
                    'options' => [
                        0 => 'The school is old and traditional',
                        1 => 'The classrooms are darker than the library',
                        2 => 'The school is very modern and beautiful',
                        3 => 'The laboratory is the same as traditional schools',
                    ],
                    'answer' => 'The school is very modern and beautiful',
                    'explanation_vi' => 'Đoạn văn nói \'The school is very modern and beautiful.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'The classrooms are as bright as the library.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'The classrooms are as bright as the library.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh thinks Thang Long School is more ___ than his own school.',
                    'options' => null,
                    'answer' => 'interesting',
                    'explanation_vi' => 'Câu cuối cùng của đoạn văn nói \'Minh thinks Thang Long School is more interesting than his own school.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'A Visit to a School',
            'title_vi' => 'Tham quan một ngôi trường',
            'instructions_en' => 'Listen to the dialogue about two students visiting a school. Answer the questions below.',
            'instructions_vi' => 'Nghe đoạn hội thoại về hai học sinh tham quan một ngôi trường. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hello Minh! Welcome to Hoa Binh School. This is our school.
Minh: Wow! Your school is very modern. The buildings are beautiful.
Linh: Thank you! This building is the classroom. It is more modern than the old building over there.
Minh: I see. Are the classrooms as big as my school\'s classrooms?
Linh: Yes, they are as big as your school\'s classrooms. Come on! Let me show you the library and the laboratory.
Minh: Great! Your school is different from my school, but I like it very much!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh think about Hoa Binh School?',
                    'options' => [
                        0 => 'It is very modern and beautiful',
                        1 => 'It is traditional and old',
                        2 => 'It is small and different',
                    ],
                    'answer' => 'It is very modern and beautiful',
                    'explanation_vi' => 'Minh nói \'Your school is very modern. The buildings are beautiful.\' - Minh nghĩ trường rất hiện đại và đẹp.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which building is more modern?',
                    'options' => [
                        0 => 'The old building is more modern',
                        1 => 'The classroom building is more modern than the old building',
                        2 => 'Both buildings are the same',
                    ],
                    'answer' => 'The classroom building is more modern than the old building',
                    'explanation_vi' => 'Linh nói \'This building is the classroom. It is more modern than the old building over there.\' - Tòa nhà lớp học hiện đại hơn tòa nhà cũ.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Are the classrooms at Hoa Binh School as big as Minh\'s school\'s classrooms?',
                    'options' => [
                        0 => 'No, they are smaller',
                        1 => 'Yes, they are as big as',
                        2 => 'No, they are bigger',
                    ],
                    'answer' => 'Yes, they are as big as',
                    'explanation_vi' => 'Linh trả lời \'Yes, they are as big as your school\'s classrooms.\' - Các lớp học cũng lớn như trường của Minh.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh wants to show Minh the ___ and the laboratory.',
                    'options' => null,
                    'answer' => 'library',
                    'explanation_vi' => 'Linh nói \'Let me show you the library and the laboratory.\' - Linh muốn cho Minh xem thư viện và phòng thí nghiệm.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Compare Two Schools',
            'title_vi' => 'So sánh Hai Ngôi Trường',
            'instructions_en' => 'Write a short paragraph comparing two schools you know (your school and another school, or your school now and in the past). Use comparative adjectives and \'as...as\' structures to describe the differences and similarities.',
            'instructions_vi' => 'Viết một đoạn văn ngắn so sánh hai ngôi trường mà em biết (trường của em và một trường khác, hoặc trường của em bây giờ và trước đây). Sử dụng tính từ so sánh và cấu trúc \'as...as\' để mô tả những điểm khác nhau và giống nhau.',
            'passage' => null,
            'prompt_en' => 'Write about two schools. Include:
- Which school is more modern, bigger, or has better facilities (classroom, library, laboratory, playground)
- How the uniforms or subjects are similar or different
- Use at least 3 comparative sentences with \'more...than\' or \'-er than\'
- Use at least 1 sentence with \'as...as\'',
            'prompt_vi' => 'Viết về hai ngôi trường. Bao gồm:
- Trường nào hiện đại hơn, lớn hơn, hoặc có cơ sở vật chất tốt hơn (lớp học, thư viện, phòng thí nghiệm, sân chơi)
- Đồng phục hoặc các môn học giống nhau hoặc khác nhau như thế nào
- Sử dụng ít nhất 3 câu so sánh với \'more...than\' hoặc \'-er than\'
- Sử dụng ít nhất 1 câu với \'as...as\'',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-7' => [
        'reading' => [
            'title_en' => 'Traffic Safety Rules',
            'title_vi' => 'Luật An Toàn Giao Thông',
            'instructions_en' => 'Read the passage about traffic safety. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về an toàn giao thông. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Traffic safety is very important in Vietnam. When you ride a motorcycle or bicycle, you should wear a helmet. It is safe and protects your head. Car drivers should wear a seatbelt. You should obey traffic lights and road signs. Never drive fast. You should follow the speed limit. Pedestrians should use the crosswalk to cross the road. It is dangerous to cross the road without looking. Children should not ride motorcycles alone. Everyone should be careful on the road.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should motorcycle riders wear?',
                    'options' => [
                        0 => 'a seatbelt',
                        1 => 'a helmet',
                        2 => 'a road sign',
                        3 => 'a crosswalk',
                    ],
                    'answer' => 'a helmet',
                    'explanation_vi' => 'Đoạn văn nói \'When you ride a motorcycle or bicycle, you should wear a helmet.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why should you wear a helmet?',
                    'options' => [
                        0 => 'It looks cool',
                        1 => 'It is cheap',
                        2 => 'It is safe and protects your head',
                        3 => 'Everyone wears one',
                    ],
                    'answer' => 'It is safe and protects your head',
                    'explanation_vi' => 'Đoạn văn nói \'It is safe and protects your head.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should pedestrians use to cross the road?',
                    'options' => [
                        0 => 'a traffic light',
                        1 => 'a bicycle',
                        2 => 'a crosswalk',
                        3 => 'a helmet',
                    ],
                    'answer' => 'a crosswalk',
                    'explanation_vi' => 'Đoạn văn nói \'Pedestrians should use the crosswalk to cross the road.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'It is safe to cross the road without looking.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'It is dangerous to cross the road without looking.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'You should obey ___ and road signs.',
                    'options' => null,
                    'answer' => 'traffic lights',
                    'explanation_vi' => 'Đoạn văn nói \'You should obey traffic lights and road signs.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Traffic Safety Rules',
            'title_vi' => 'Luật An Toàn Giao Thông',
            'instructions_en' => 'Listen to the conversation about traffic safety. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về an toàn giao thông. Sau đó trả lời các câu hỏi.',
            'passage' => 'Minh: Hi Lan! Do you ride your bicycle to school?
Lan: Yes, I do. But my mother says I should wear a helmet. It\'s safe.
Minh: That\'s good. I ride my motorcycle. I always wear a helmet too.
Lan: You should obey the traffic lights. Red means stop.
Minh: Yes, I know. Pedestrians should use the crosswalk. It\'s not dangerous there.
Lan: Right! And we shouldn\'t go fast. Speed limits are important for safety.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Lan ride to school?',
                    'options' => [
                        0 => 'a motorcycle',
                        1 => 'a bicycle',
                        2 => 'a bus',
                    ],
                    'answer' => 'a bicycle',
                    'explanation_vi' => 'Lan nói \'Yes, I do\' khi Minh hỏi cô ấy có đi xe đạp đến trường không.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should Minh do when the traffic light is red?',
                    'options' => [
                        0 => 'go fast',
                        1 => 'stop',
                        2 => 'turn left',
                    ],
                    'answer' => 'stop',
                    'explanation_vi' => 'Lan nói \'Red means stop\' - đèn đỏ có nghĩa là dừng lại.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where should pedestrians cross the road?',
                    'options' => [
                        0 => 'at the traffic light',
                        1 => 'at the crosswalk',
                        2 => 'anywhere',
                    ],
                    'answer' => 'at the crosswalk',
                    'explanation_vi' => 'Minh nói \'Pedestrians should use the crosswalk\' - người đi bộ nên sử dụng đường qua đường.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Lan\'s mother says she should wear a ___ when riding her bicycle.',
                    'options' => null,
                    'answer' => 'helmet',
                    'explanation_vi' => 'Lan nói \'my mother says I should wear a helmet\' - mẹ cô ấy nói cô nên đội mũ bảo hiểm.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Traffic Safety Advice',
            'title_vi' => 'Lời khuyên về An toàn Giao thông',
            'instructions_en' => 'Write a short text giving traffic safety advice. Use \'should\' and \'shouldn\'t\' to explain what people must do to stay safe on the road. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn về lời khuyên an toàn giao thông. Sử dụng \'should\' và \'shouldn\'t\' để giải thích những gì mọi người phải làm để an toàn trên đường. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write advice for road users in Vietnam. Include:
- What helmet and seatbelt users should wear
- What traffic lights and road signs people should obey
- What dangerous things pedestrians and cyclists shouldn\'t do',
            'prompt_vi' => 'Viết lời khuyên cho những người sử dụng đường bộ ở Việt Nam. Bao gồm:
- Những gì người dùng mũ bảo hiểm và dây an toàn nên đội/mặc
- Những gì mọi người nên tuân theo về đèn giao thông và biển báo đường
- Những điều nguy hiểm mà người đi bộ và người đi xe đạp không nên làm',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-8' => [
        'reading' => [
            'title_en' => 'An Invitation to the Cinema',
            'title_vi' => 'Lời mời đến rạp chiếu phim',
            'instructions_en' => 'Read the passage about Linh and Minh\'s plan to watch a film. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về kế hoạch xem phim của Linh và Minh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh is at the cinema with her friend Minh. Linh says, "Would you like to watch a comedy or an action film?" Minh replies, "I would like to watch an action film. Action films are exciting!" Linh agrees and recommends a new film called "City Hero". The director is very famous, and the main actor is fantastic. The reviews say the film is not boring at all. "Would you like to invite Tuan to watch it with us?" asks Linh. Minh says, "Yes! That\'s a great idea. Tuan loves exciting films." They buy three tickets for 150,000 dong each.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What type of film does Minh want to watch?',
                    'options' => [
                        0 => 'A comedy',
                        1 => 'An action film',
                        2 => 'A drama',
                        3 => 'A thriller',
                    ],
                    'answer' => 'An action film',
                    'explanation_vi' => 'Minh nói \'I would like to watch an action film\' trong đoạn văn.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is the name of the film they recommend?',
                    'options' => [
                        0 => 'City Love',
                        1 => 'City Hero',
                        2 => 'Hero City',
                        3 => 'City Dream',
                    ],
                    'answer' => 'City Hero',
                    'explanation_vi' => 'Linh giới thiệu một bộ phim mới gọi là \'City Hero\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How much does each ticket cost?',
                    'options' => [
                        0 => '100,000 dong',
                        1 => '120,000 dong',
                        2 => '150,000 dong',
                        3 => '200,000 dong',
                    ],
                    'answer' => '150,000 dong',
                    'explanation_vi' => 'Đoạn văn nói \'They buy three tickets for 150,000 dong each\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Minh thinks action films are boring.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Minh nói \'Action films are exciting!\' - anh ấy không nghĩ chúng chán.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The main ___ in \'City Hero\' is fantastic.',
                    'options' => null,
                    'answer' => 'actor',
                    'explanation_vi' => 'Đoạn văn nói \'the main actor is fantastic\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Going to the Cinema',
            'title_vi' => 'Đi xem phim',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe nó hai lần. Sau đó trả lời các câu hỏi.',
            'passage' => 'Minh: Hi Linh! Would you like to go to the cinema this Saturday?
Linh: Oh, that sounds great! What film would you like to watch?
Minh: There is a new action film. The director is very famous. The actors are fantastic.
Linh: Is it exciting?
Minh: Yes, very exciting! The review says it is not boring at all.
Linh: Perfect! I would like to watch it. What time?
Minh: Seven o\'clock. Would you like to have dinner before the film?
Linh: Yes, I would like that!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What type of film does Minh recommend?',
                    'options' => [
                        0 => 'A comedy',
                        1 => 'An action film',
                        2 => 'A thriller',
                    ],
                    'answer' => 'An action film',
                    'explanation_vi' => 'Minh nói \'There is a new action film.\' (Có một bộ phim hành động mới.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What time do they want to watch the film?',
                    'options' => [
                        0 => 'Six o\'clock',
                        1 => 'Seven o\'clock',
                        2 => 'Eight o\'clock',
                    ],
                    'answer' => 'Seven o\'clock',
                    'explanation_vi' => 'Minh nói \'Seven o\'clock.\' (Lúc 7 giờ.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Does Linh want to go to the cinema?',
                    'options' => [
                        0 => 'No, she thinks it is boring',
                        1 => 'Yes, she thinks it sounds great',
                        2 => 'No, she is busy',
                    ],
                    'answer' => 'Yes, she thinks it sounds great',
                    'explanation_vi' => 'Linh nói \'Oh, that sounds great!\' (Ồ, điều đó nghe tuyệt vời!)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh says: \'I would like to _____ it.\'',
                    'options' => null,
                    'answer' => 'watch',
                    'explanation_vi' => 'Linh nói \'I would like to watch it.\' (Tôi muốn xem nó.)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Invite a Friend to the Cinema',
            'title_vi' => 'Mời bạn đi xem phim',
            'instructions_en' => 'Write a short invitation to a friend to go to the cinema. Use \'Would you like to...?\' to invite them. Describe a film you want to watch and explain why. Accept or decline the invitation in a response.',
            'instructions_vi' => 'Viết một lời mời ngắn cho bạn đi xem phim. Dùng \'Would you like to...?\' để mời bạn. Mô tả một bộ phim bạn muốn xem và giải thích tại sao. Viết câu trả lời chấp nhận hoặc từ chối lời mời.',
            'passage' => null,
            'prompt_en' => 'Write two short messages:
1. An invitation message to your friend. Include:
- A question using \'Would you like to...?\'
- The name of a film and its type (comedy, action, drama, or thriller)
- One reason why the film is good (use: exciting, fantastic, or boring)

2. Your friend\'s response. Include:
- An answer (yes or no)
- One more reason about the film or actor/actress',
            'prompt_vi' => 'Viết hai tin nhắn ngắn:
1. Một lời mời cho bạn của bạn. Bao gồm:
- Một câu hỏi dùng \'Would you like to...?\'
- Tên một bộ phim và thể loại (comedy, action, drama, hoặc thriller)
- Một lý do tại sao bộ phim hay (dùng: exciting, fantastic, hoặc boring)

2. Câu trả lời của bạn bạn. Bao gồm:
- Một câu trả lời (có hoặc không)
- Một lý do khác về bộ phim hoặc diễn viên',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-9' => [
        'reading' => [
            'title_en' => 'Tet Festival in Vietnam',
            'title_vi' => 'Lễ hội Tết ở Việt Nam',
            'instructions_en' => 'Read the passage about Tet Festival. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về Lễ hội Tết. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Tet is the most important festival in Vietnam. It is celebrated in January or February every year. During Tet, colorful decorations are put up in homes and streets. Lanterns are hung everywhere, and parades are organized in many cities. Families gather together to enjoy special food like bánh chưng and mứt. Traditional music and dance are performed at the festival. Fireworks are lit to welcome the new year. Many people participate in the celebrations by wearing beautiful costumes. Tet is an exciting time when Vietnamese traditions are shared and enjoyed by everyone.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'When is Tet celebrated?',
                    'options' => [
                        0 => 'In January or February',
                        1 => 'In March or April',
                        2 => 'In June or July',
                        3 => 'In December',
                    ],
                    'answer' => 'In January or February',
                    'explanation_vi' => 'Đoạn văn nói \'It is celebrated in January or February every year.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What are hung everywhere during Tet?',
                    'options' => [
                        0 => 'Costumes',
                        1 => 'Lanterns',
                        2 => 'Parades',
                        3 => 'Music',
                    ],
                    'answer' => 'Lanterns',
                    'explanation_vi' => 'Đoạn văn nói \'Lanterns are hung everywhere.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What do families do during Tet?',
                    'options' => [
                        0 => 'They work in the office',
                        1 => 'They gather together to enjoy special food',
                        2 => 'They sleep all day',
                        3 => 'They study at school',
                    ],
                    'answer' => 'They gather together to enjoy special food',
                    'explanation_vi' => 'Đoạn văn nói \'Families gather together to enjoy special food.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Fireworks are lit during Tet to welcome the new year.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'Fireworks are lit to welcome the new year.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Colorful ___ are put up in homes and streets during Tet.',
                    'options' => null,
                    'answer' => 'decorations',
                    'explanation_vi' => 'Đoạn văn nói \'colorful decorations are put up in homes and streets.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Tết Festival in Vietnam',
            'title_vi' => 'Lễ hội Tết ở Việt Nam',
            'instructions_en' => 'Listen to the conversation about Tết Festival. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc trò chuyện về Lễ hội Tết. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! Do you celebrate Tết Festival in your family?
Minh: Yes, we do! Tết is celebrated in January or February. It is a very important tradition.
Linh: That sounds exciting! What happens at Tết?
Minh: Many things! The streets are decorated with colorful lanterns and flowers. A big parade takes place in the city center. People wear beautiful costumes and dance to traditional music.
Linh: Do you participate in the parade?
Minh: Sometimes! But I enjoy watching the fireworks with my family. We also gather together and eat special food.
Linh: That\'s wonderful!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'When is Tết Festival celebrated?',
                    'options' => [
                        0 => 'January or February',
                        1 => 'March or April',
                        2 => 'December or January',
                    ],
                    'answer' => 'January or February',
                    'explanation_vi' => 'Minh nói: \'Tết is celebrated in January or February\' (Tết được tổ chức vào tháng Một hoặc tháng Hai).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What are the streets decorated with?',
                    'options' => [
                        0 => 'Colorful lanterns and flowers',
                        1 => 'Colorful balloons and trees',
                        2 => 'Colorful ribbons and lights',
                    ],
                    'answer' => 'Colorful lanterns and flowers',
                    'explanation_vi' => 'Minh nói: \'The streets are decorated with colorful lanterns and flowers\' (Các đường phố được trang trí bằng những chiếc lồng đèn đầy màu sắc và hoa).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh enjoy watching at Tết?',
                    'options' => [
                        0 => 'The parade',
                        1 => 'The fireworks',
                        2 => 'The costumes',
                    ],
                    'answer' => 'The fireworks',
                    'explanation_vi' => 'Minh nói: \'I enjoy watching the fireworks with my family\' (Tôi thích xem pháo hoa với gia đình).',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'People wear beautiful ___ and dance to traditional music.',
                    'options' => null,
                    'answer' => 'costumes',
                    'explanation_vi' => 'Minh nói: \'People wear beautiful costumes and dance to traditional music\' (Mọi người mặc những trang phục đẹp và nhảy múa theo âm nhạc truyền thống).',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Writing about a Festival in Vietnam',
            'title_vi' => 'Viết về một lễ hội ở Việt Nam',
            'instructions_en' => 'Write a short paragraph (50-80 words) about a festival celebrated in Vietnam. Use the present simple passive voice to describe what happens at the festival. You can choose Tết, Mid-Autumn Festival, or another Vietnamese festival you know.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) về một lễ hội được tổ chức ở Việt Nam. Sử dụng thể bị động ở hiện tại đơn để mô tả những gì xảy ra tại lễ hội. Bạn có thể chọn Tết, Tết Trung Thu hoặc một lễ hội Việt Nam khác mà bạn biết.',
            'passage' => null,
            'prompt_en' => 'Write about a Vietnamese festival. Include:
- The name of the festival and when it takes place
- What is decorated and what decorations are used (use \'is/are decorated\')
- What special activities are done at the festival (use \'is/are celebrated\', \'is/are enjoyed\', etc.)',
            'prompt_vi' => 'Viết về một lễ hội Việt Nam. Bao gồm:
- Tên lễ hội và khi nào nó diễn ra
- Những gì được trang trí và những trang trí nào được sử dụng (sử dụng \'is/are decorated\')
- Những hoạt động đặc biệt nào được thực hiện tại lễ hội (sử dụng \'is/are celebrated\', \'is/are enjoyed\', v.v.)',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-10' => [
        'reading' => [
            'title_en' => 'Energy Sources in Vietnam',
            'title_vi' => 'Nguồn Năng Lượng Ở Việt Nam',
            'instructions_en' => 'Read the passage about energy sources. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về nguồn năng lượng. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Vietnam uses many sources of energy. Electricity is produced from coal, oil, and renewable sources. Coal and oil are fossil fuels. They pollute the environment. Solar energy and wind energy are renewable sources. Hydro energy is also renewable and efficient. These sources do not pollute the environment.

We should save energy every day. We can turn off lights and switch off fans when we do not use them. We should not waste electricity. Renewable energy is important for our future. It helps protect the environment.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What are coal and oil?',
                    'options' => [
                        0 => 'Renewable sources',
                        1 => 'Fossil fuels',
                        2 => 'Types of electricity',
                        3 => 'Solar energy',
                    ],
                    'answer' => 'Fossil fuels',
                    'explanation_vi' => 'Đoạn văn nói "Coal and oil are fossil fuels."',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which energy source is renewable and efficient?',
                    'options' => [
                        0 => 'Coal energy',
                        1 => 'Oil energy',
                        2 => 'Hydro energy',
                        3 => 'Fossil fuel energy',
                    ],
                    'answer' => 'Hydro energy',
                    'explanation_vi' => 'Đoạn văn nói "Hydro energy is also renewable and efficient."',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should we do to save energy?',
                    'options' => [
                        0 => 'Use more electricity',
                        1 => 'Turn off lights and switch off fans',
                        2 => 'Pollute the environment',
                        3 => 'Waste energy',
                    ],
                    'answer' => 'Turn off lights and switch off fans',
                    'explanation_vi' => 'Đoạn văn nói "We can turn off lights and switch off fans when we do not use them."',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Solar energy and wind energy pollute the environment.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói "These sources do not pollute the environment." (về năng lượng tái tạo)',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Electricity is produced from coal, oil, and ___ sources.',
                    'options' => null,
                    'answer' => 'renewable',
                    'explanation_vi' => 'Câu đầu tiên của đoạn văn nói "Electricity is produced from coal, oil, and renewable sources."',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Energy Sources in Vietnam',
            'title_vi' => 'Nguồn năng lượng ở Việt Nam',
            'instructions_en' => 'Listen to the conversation about energy sources. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về nguồn năng lượng. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Nam, do you know where electricity is produced in Vietnam?
Nam: Yes, electricity is produced from many sources. Coal and oil are fossil fuels.
Linh: Are fossil fuels renewable?
Nam: No, they are not renewable. They pollute the environment.
Linh: What about solar and wind energy?
Nam: Solar and wind energy are renewable sources. They are efficient and they don\'t pollute.
Linh: That\'s great! We should save energy and not waste it.
Nam: Yes! We can turn off lights and switch off computers when we don\'t use them.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where is electricity produced from in Vietnam?',
                    'options' => [
                        0 => 'Only from coal',
                        1 => 'From many sources like coal, oil, solar, and wind',
                        2 => 'Only from solar energy',
                    ],
                    'answer' => 'From many sources like coal, oil, solar, and wind',
                    'explanation_vi' => 'Nam nói rằng điện được sản xuất từ nhiều nguồn. Anh ấy đề cập đến than đá, dầu mỏ, năng lượng mặt trời và gió.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Are coal and oil renewable sources?',
                    'options' => [
                        0 => 'Yes, they are renewable',
                        1 => 'No, they are not renewable',
                        2 => 'Yes, they are efficient',
                    ],
                    'answer' => 'No, they are not renewable',
                    'explanation_vi' => 'Nam trả lời rằng than đá và dầu mỏ không phải là nguồn tái tạo được. Chúng là nhiên liệu hóa thạch.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is good about solar and wind energy?',
                    'options' => [
                        0 => 'They pollute the environment',
                        1 => 'They are renewable and efficient, and they don\'t pollute',
                        2 => 'They are fossil fuels',
                    ],
                    'answer' => 'They are renewable and efficient, and they don\'t pollute',
                    'explanation_vi' => 'Nam nói rằng năng lượng mặt trời và gió là những nguồn tái tạo được, hiệu quả và không gây ô nhiễm.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'We should save energy and not ___ it.',
                    'options' => null,
                    'answer' => 'waste',
                    'explanation_vi' => 'Linh nói \'We should save energy and not waste it\' - chúng ta nên tiết kiệm năng lượng và không lãng phí nó.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'How Energy is Produced and Used',
            'title_vi' => 'Năng lượng được sản xuất và sử dụng như thế nào',
            'instructions_en' => 'Write a short paragraph about energy sources in Vietnam. Use the present simple passive voice to explain how different types of energy are produced. Include at least one sentence about saving energy.',
            'instructions_vi' => 'Viết một đoạn văn ngắn về các nguồn năng lượng ở Việt Nam. Sử dụng thể bị động ở hiện tại đơn để giải thích cách các loại năng lượng được sản xuất. Bao gồm ít nhất một câu về tiết kiệm năng lượng.',
            'passage' => null,
            'prompt_en' => 'Write about energy sources in Vietnam. Include:
- At least two types of energy that are produced in Vietnam (coal, oil, solar, wind, or hydro) and explain how they are produced using passive voice
- One sentence about how electricity is used in your home
- One sentence about how you save energy or how energy waste can be reduced',
            'prompt_vi' => 'Viết về các nguồn năng lượng ở Việt Nam. Bao gồm:
- Ít nhất hai loại năng lượng được sản xuất ở Việt Nam (than đá, dầu mỏ, năng lượng mặt trời, gió, hoặc thủy điện) và giải thích cách chúng được sản xuất bằng thể bị động
- Một câu về cách điện được sử dụng trong nhà bạn
- Một câu về cách bạn tiết kiệm năng lượng hoặc cách giảm lãng phí năng lượng',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-11' => [
        'reading' => [
            'title_en' => 'Travel in the Future',
            'title_vi' => 'Du lịch trong tương lai',
            'instructions_en' => 'Read the passage about future travel. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về du lịch trong tương lai. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'In the future, travel will be very different. Scientists predict that flying cars will hover above the streets in big cities. These vehicles will be solar-powered and eco-friendly, so there will be less pollution. People might use spacecraft to travel to other planets for vacation. Driverless cars will probably be automatic and very safe. Some experts think we might even teleport from one place to another! New technology will change how we travel. The speed of transport will be much faster than today.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does the passage say flying cars will do in big cities?',
                    'options' => [
                        0 => 'They will hover above the streets',
                        1 => 'They will travel under the ground',
                        2 => 'They will move very slowly',
                        3 => 'They will stop in traffic',
                    ],
                    'answer' => 'They will hover above the streets',
                    'explanation_vi' => 'Đoạn văn nói rõ \'flying cars will hover above the streets in big cities\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the passage, what type of energy will power future vehicles?',
                    'options' => [
                        0 => 'Wind power',
                        1 => 'Solar power',
                        2 => 'Water power',
                        3 => 'Gas power',
                    ],
                    'answer' => 'Solar power',
                    'explanation_vi' => 'Đoạn văn nói \'These vehicles will be solar-powered\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What might people use to travel to other planets?',
                    'options' => [
                        0 => 'Flying cars',
                        1 => 'Driverless cars',
                        2 => 'Spacecraft',
                        3 => 'Automatic vehicles',
                    ],
                    'answer' => 'Spacecraft',
                    'explanation_vi' => 'Đoạn văn nói \'People might use spacecraft to travel to other planets for vacation\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Driverless cars will probably be automatic and very safe.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Câu này được nêu trực tiếp trong đoạn văn: \'Driverless cars will probably be automatic and very safe\'.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Future vehicles will be solar-powered and eco-friendly, so there will be less ___.',
                    'options' => null,
                    'answer' => 'pollution',
                    'explanation_vi' => 'Đoạn văn nói \'These vehicles will be solar-powered and eco-friendly, so there will be less pollution\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Travel in the Future',
            'title_vi' => 'Du lịch trong tương lai',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe hai lần. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! What do you think about travel in the future?
Minh: I think flying cars will be very popular. They will hover above the streets.
Linh: That sounds amazing! Will they be eco-friendly?
Minh: Yes, they might be solar-powered. That will reduce pollution.
Linh: What about other vehicles?
Minh: I predict we will have driverless cars. They will have automatic technology.
Linh: Will they be fast?
Minh: Yes! They will probably have high speed. Travel will be very different!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh think will be very popular in the future?',
                    'options' => [
                        0 => 'Driverless cars',
                        1 => 'Flying cars',
                        2 => 'Spacecraft',
                    ],
                    'answer' => 'Flying cars',
                    'explanation_vi' => 'Minh nói \'I think flying cars will be very popular.\' (Tôi nghĩ xe bay sẽ rất phổ biến.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How will flying cars move in the future?',
                    'options' => [
                        0 => 'They will drive on the ground',
                        1 => 'They will hover above the streets',
                        2 => 'They will teleport',
                    ],
                    'answer' => 'They will hover above the streets',
                    'explanation_vi' => 'Minh nói \'They will hover above the streets.\' (Chúng sẽ lơ lửng phía trên các con phố.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What technology will driverless cars have?',
                    'options' => [
                        0 => 'Solar-powered technology',
                        1 => 'Automatic technology',
                        2 => 'Flying technology',
                    ],
                    'answer' => 'Automatic technology',
                    'explanation_vi' => 'Minh nói \'They will have automatic technology.\' (Chúng sẽ có công nghệ tự động.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Flying cars might be ___ to reduce pollution.',
                    'options' => null,
                    'answer' => 'solar-powered',
                    'explanation_vi' => 'Minh nói \'they might be solar-powered. That will reduce pollution.\' (chúng có thể chạy bằng năng lượng mặt trời. Điều đó sẽ giảm ô nhiễm.)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Future Travel Prediction',
            'title_vi' => 'Dự đoán du lịch của tôi trong tương lai',
            'instructions_en' => 'Write a short paragraph (50-80 words) predicting how you will travel in the future. Use \'will\' for things you think are certain and \'might\' for things that are possible. Include at least 3 words from the unit vocabulary.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) dự đoán cách bạn sẽ du lịch trong tương lai. Sử dụng \'will\' cho những điều bạn chắc chắn và \'might\' cho những điều có thể xảy ra. Bao gồm ít nhất 3 từ từ vựng của bài học.',
            'passage' => null,
            'prompt_en' => 'Write about your future travel. Include:
- One type of vehicle or transport you will use (e.g., flying car, driverless car, spacecraft)
- Why this vehicle will be good (e.g., eco-friendly, fast, automatic)
- One possibility using \'might\' (e.g., you might teleport, there might be less pollution)',
            'prompt_vi' => 'Viết về du lịch trong tương lai của bạn. Bao gồm:
- Một loại phương tiện giao thông bạn sẽ sử dụng (ví dụ: xe bay, xe không người lái, tàu vũ trụ)
- Tại sao phương tiện này sẽ tốt (ví dụ: thân thiện với môi trường, nhanh, tự động)
- Một khả năng sử dụng \'might\' (ví dụ: bạn có thể dịch chuyển tức thời, có thể ít ô nhiễm hơn)',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '7-12' => [
        'reading' => [
            'title_en' => 'English-Speaking Countries Around the World',
            'title_vi' => 'Các nước nói tiếng Anh trên thế giới',
            'instructions_en' => 'Read the passage about English-speaking countries. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về các nước nói tiếng Anh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'There are many English-speaking countries in the world. The United States has a large population and its capital is Washington, D.C. There is a famous landmark called the Statue of Liberty in New York. The United Kingdom is in Europe, and its capital is London. Big Ben is a very famous landmark there. Australia is a big country in the Southern Hemisphere. Sydney is the largest city, and there is the Sydney Opera House, which is a beautiful landmark. Canada is north of the United States. There is Niagara Falls, one of the most famous landmarks in Canada. All these countries have English as their main language and share similar cultures.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is the capital of the United States?',
                    'options' => [
                        0 => 'New York',
                        1 => 'Washington, D.C.',
                        2 => 'London',
                        3 => 'Sydney',
                    ],
                    'answer' => 'Washington, D.C.',
                    'explanation_vi' => 'Đoạn văn nói rõ \'The United States has a large population and its capital is Washington, D.C.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which landmark is in Canada?',
                    'options' => [
                        0 => 'Big Ben',
                        1 => 'Statue of Liberty',
                        2 => 'Niagara Falls',
                        3 => 'Sydney Opera House',
                    ],
                    'answer' => 'Niagara Falls',
                    'explanation_vi' => 'Đoạn văn nói \'There is Niagara Falls, one of the most famous landmarks in Canada.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where is the Sydney Opera House located?',
                    'options' => [
                        0 => 'United Kingdom',
                        1 => 'United States',
                        2 => 'Canada',
                        3 => 'Australia',
                    ],
                    'answer' => 'Australia',
                    'explanation_vi' => 'Đoạn văn nói \'Sydney is the largest city, and there is the Sydney Opera House\' trong phần nói về Australia.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Big Ben is a famous landmark in the United Kingdom.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'The United Kingdom is in Europe, and its capital is London. Big Ben is a very famous landmark there.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'There are many ___ countries in the world.',
                    'options' => null,
                    'answer' => 'English-speaking',
                    'explanation_vi' => 'Câu đầu tiên của đoạn văn là \'There are many English-speaking countries in the world.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'English-Speaking Countries',
            'title_vi' => 'Các nước nói tiếng Anh',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe nó hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Nam! Do you know about English-speaking countries?
Nam: Yes, I do! There are many English-speaking countries in the world.
Linh: What are some examples?
Nam: Well, there is the United States. The capital is Washington, D.C. There is a famous landmark called the Statue of Liberty.
Linh: That\'s great! Are there other countries?
Nam: Yes! There is the United Kingdom. The capital is London. There is Big Ben there. There is also Australia. Sydney Opera House is a famous landmark in Australia.
Linh: Wow! I love learning about these countries!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is the capital of the United States?',
                    'options' => [
                        0 => 'New York',
                        1 => 'Washington, D.C.',
                        2 => 'Los Angeles',
                    ],
                    'answer' => 'Washington, D.C.',
                    'explanation_vi' => 'Nam nói: \'The capital is Washington, D.C.\' khi nói về Hoa Kỳ.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which landmark is in the United Kingdom?',
                    'options' => [
                        0 => 'Statue of Liberty',
                        1 => 'Big Ben',
                        2 => 'Sydney Opera House',
                    ],
                    'answer' => 'Big Ben',
                    'explanation_vi' => 'Nam nói: \'There is Big Ben there\' khi nói về Vương quốc Anh.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is a famous landmark in Australia?',
                    'options' => [
                        0 => 'Niagara Falls',
                        1 => 'Big Ben',
                        2 => 'Sydney Opera House',
                    ],
                    'answer' => 'Sydney Opera House',
                    'explanation_vi' => 'Nam nói: \'Sydney Opera House is a famous landmark in Australia.\'',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'There are many ___ countries in the world.',
                    'options' => null,
                    'answer' => 'English-speaking',
                    'explanation_vi' => 'Nam nói: \'There are many English-speaking countries in the world.\' Đây là cách để mô tả các nước nói tiếng Anh.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Describe an English-Speaking Country',
            'title_vi' => 'Mô tả một đất nước nói tiếng Anh',
            'instructions_en' => 'Choose one English-speaking country from the unit (United States, United Kingdom, Australia, or Canada). Write a short description of the country using \'There is\' and \'There are\' to talk about its landmarks and features. Write 50-80 words.',
            'instructions_vi' => 'Chọn một đất nước nói tiếng Anh từ bài học (Hoa Kỳ, Vương quốc Anh, Úc, hoặc Canada). Viết một đoạn mô tả ngắn về đất nước đó bằng cách sử dụng \'There is\' và \'There are\' để nói về các địa danh nổi tiếng và đặc điểm của nó. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your chosen English-speaking country. Include:
- The name of the country and its capital
- At least two famous landmarks using \'There is\' or \'There are\'
- One sentence about the language or culture',
            'prompt_vi' => 'Viết về đất nước nói tiếng Anh mà bạn chọn. Bao gồm:
- Tên đất nước và thủ đô của nó
- Ít nhất hai địa danh nổi tiếng bằng cách sử dụng \'There is\' hoặc \'There are\'
- Một câu về ngôn ngữ hoặc văn hóa',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-1' => [
        'reading' => [
            'title_en' => 'Minh\'s Leisure Time',
            'title_vi' => 'Thời gian rảnh của Minh',
            'instructions_en' => 'Read the passage about Minh\'s hobbies and leisure activities. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về các sở thích và hoạt động rảnh rỗi của Minh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh is a student in Hà Nội. In his free time, he enjoys playing sports very much. He loves playing football with his friends after school. He also likes watching films on weekends. Minh\'s favourite hobby is reading. He enjoys reading adventure stories and comic books. However, he hates doing homework! On Sundays, Minh prefers listening to music and drawing. He is interested in cooking too, and he enjoys making bánh mì and phở with his mother.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Minh\'s favourite hobby?',
                    'options' => [
                        0 => 'Playing football',
                        1 => 'Reading',
                        2 => 'Watching films',
                        3 => 'Cooking',
                    ],
                    'answer' => 'Reading',
                    'explanation_vi' => 'Đoạn văn nói \'Minh\'s favourite hobby is reading.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh enjoy doing on Sundays?',
                    'options' => [
                        0 => 'Playing football and watching films',
                        1 => 'Listening to music and drawing',
                        2 => 'Reading and cooking',
                        3 => 'Playing sports and doing homework',
                    ],
                    'answer' => 'Listening to music and drawing',
                    'explanation_vi' => 'Đoạn văn nói \'On Sundays, Minh prefers listening to music and drawing.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Who does Minh play football with?',
                    'options' => [
                        0 => 'His mother',
                        1 => 'His teachers',
                        2 => 'His friends',
                        3 => 'His family',
                    ],
                    'answer' => 'His friends',
                    'explanation_vi' => 'Đoạn văn nói \'He loves playing football with his friends after school.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Minh likes doing homework.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'he hates doing homework\' nên câu này là sai.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh enjoys making bánh mì and phở with his ___.',
                    'options' => null,
                    'answer' => 'mother',
                    'explanation_vi' => 'Đoạn văn nói \'he enjoys making bánh mì and phở with his mother.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Leisure Time Preferences',
            'title_vi' => 'Sở thích thời gian rảnh',
            'instructions_en' => 'Listen to the conversation about leisure activities. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc trò chuyện về các hoạt động thời gian rảnh. Bạn sẽ nghe hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! What do you like doing in your free time?
Minh: I enjoy playing sports very much. I love playing football with my friends.
Linh: That\'s great! I hate playing sports. I prefer reading books and drawing.
Minh: Really? Do you like listening to music?
Linh: Yes, I do! I enjoy listening to music every day. What about cooking? Do you like cooking?
Minh: No, I dislike cooking. But I\'m interested in watching films on weekends.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh enjoy doing in his free time?',
                    'options' => [
                        0 => 'Reading books and drawing',
                        1 => 'Playing sports and watching films',
                        2 => 'Cooking and listening to music',
                    ],
                    'answer' => 'Playing sports and watching films',
                    'explanation_vi' => 'Minh nói \'I enjoy playing sports very much\' và \'I\'m interested in watching films on weekends\'. Những hoạt động này là những gì Minh thích làm.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh prefer to do?',
                    'options' => [
                        0 => 'Playing football and watching films',
                        1 => 'Reading books and drawing',
                        2 => 'Cooking and playing sports',
                    ],
                    'answer' => 'Reading books and drawing',
                    'explanation_vi' => 'Linh nói \'I prefer reading books and drawing.\' Đây là những hoạt động mà Linh thích hơn.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How does Minh feel about cooking?',
                    'options' => [
                        0 => 'He loves cooking',
                        1 => 'He enjoys cooking',
                        2 => 'He dislikes cooking',
                    ],
                    'answer' => 'He dislikes cooking',
                    'explanation_vi' => 'Minh nói \'No, I dislike cooking.\' Điều này cho thấy anh ấy không thích nấu ăn.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh enjoys ___ every day.',
                    'options' => null,
                    'answer' => 'listening to music',
                    'explanation_vi' => 'Linh nói \'I enjoy listening to music every day.\' Đây là hoạt động mà Linh thích làm hàng ngày.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Leisure Time Preferences',
            'title_vi' => 'Những sở thích của tôi trong thời gian rảnh',
            'instructions_en' => 'Write about your leisure time activities and what you like or dislike doing. Use the grammar structure: Like/Love/Enjoy/Hate + V-ing. Write 50-80 words.',
            'instructions_vi' => 'Viết về các hoạt động thời gian rảnh của bạn và những gì bạn thích hoặc không thích làm. Sử dụng cấu trúc ngữ pháp: Like/Love/Enjoy/Hate + V-ing. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your free time and hobbies. Include:
- What leisure activities you like or love doing
- What activities you dislike or hate doing
- One activity you prefer to do more than others',
            'prompt_vi' => 'Viết về thời gian tự do và sở thích của bạn. Bao gồm:
- Những hoạt động thời gian rảnh mà bạn thích hoặc yêu thích làm
- Những hoạt động mà bạn không thích hoặc ghét làm
- Một hoạt động mà bạn thích làm hơn những hoạt động khác',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-2' => [
        'reading' => [
            'title_en' => 'Life in the Countryside',
            'title_vi' => 'Cuộc sống ở nông thôn',
            'instructions_en' => 'Read the passage about life in the countryside. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về cuộc sống ở nông thôn. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Hạnh lives in a small village in the countryside near Hà Nội. Her lifestyle is very different from city life. The countryside is more peaceful and has fresher air compared to the city. There is less pollution here. Hạnh\'s family has a farm where they grow rice and vegetables. Every year, they harvest their crops in autumn. Life in the countryside is simpler than in the city, but the community is very strong. People help each other. However, the countryside has fewer facilities and is less convenient than the city. There are not many shops or schools nearby. Despite these challenges, Hạnh loves her peaceful life and fresh air.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where does Hạnh live?',
                    'options' => [
                        0 => 'In a small village in the countryside near Hà Nội',
                        1 => 'In a big city in the center of Hà Nội',
                        2 => 'On a farm in the mountains',
                        3 => 'In a crowded neighborhood',
                    ],
                    'answer' => 'In a small village in the countryside near Hà Nội',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Hạnh lives in a small village in the countryside near Hà Nội\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Hạnh\'s family grow on their farm?',
                    'options' => [
                        0 => 'Only rice',
                        1 => 'Only vegetables',
                        2 => 'Rice and vegetables',
                        3 => 'Fruits and flowers',
                    ],
                    'answer' => 'Rice and vegetables',
                    'explanation_vi' => 'Đoạn văn nói \'they grow rice and vegetables\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How is the countryside compared to the city?',
                    'options' => [
                        0 => 'More crowded and more convenient',
                        1 => 'More peaceful and has fresher air',
                        2 => 'More polluted and less peaceful',
                        3 => 'Less simple and more modern',
                    ],
                    'answer' => 'More peaceful and has fresher air',
                    'explanation_vi' => 'Đoạn văn nói \'The countryside is more peaceful and has fresher air compared to the city\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'The countryside has more facilities and is more convenient than the city.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'the countryside has fewer facilities and is less convenient than the city\'.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Hạnh\'s family harvests their crops in ___.',
                    'options' => null,
                    'answer' => 'autumn',
                    'explanation_vi' => 'Đoạn văn nói \'they harvest their crops in autumn\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Life in the Countryside',
            'title_vi' => 'Cuộc sống ở nông thôn',
            'instructions_en' => 'Listen to the conversation between Linh and Minh about life in the countryside and the city. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại giữa Linh và Minh về cuộc sống ở nông thôn và thành phố. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! Do you like living in the countryside?
Minh: Yes, I do! The countryside is more peaceful than the city.
Linh: That\'s true. The air is fresher here too.
Minh: Exactly. There is less pollution compared to the city. The city is very crowded.
Linh: I agree. But the city has more convenient facilities.
Minh: Yes, but I prefer the simple lifestyle here. My family works on a farm and grows crops.
Linh: That sounds nice. When do you harvest?
Minh: We harvest in autumn. The community here is very friendly.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to Minh, how is the countryside different from the city?',
                    'options' => [
                        0 => 'The countryside is more crowded than the city',
                        1 => 'The countryside is more peaceful than the city',
                        2 => 'The countryside has more facilities than the city',
                    ],
                    'answer' => 'The countryside is more peaceful than the city',
                    'explanation_vi' => 'Minh nói: \'The countryside is more peaceful than the city\' (Nông thôn yên tĩnh hơn thành phố)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh\'s family do?',
                    'options' => [
                        0 => 'They work in a shop in the city',
                        1 => 'They work on a farm and grow crops',
                        2 => 'They work in a school',
                    ],
                    'answer' => 'They work on a farm and grow crops',
                    'explanation_vi' => 'Minh nói: \'My family works on a farm and grows crops\' (Gia đình tôi làm việc trên một trang trại và trồng cây)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh say about the city?',
                    'options' => [
                        0 => 'The city has more convenient facilities',
                        1 => 'The city is more peaceful',
                        2 => 'The city has fresher air',
                    ],
                    'answer' => 'The city has more convenient facilities',
                    'explanation_vi' => 'Linh nói: \'The city has more convenient facilities\' (Thành phố có nhiều tiện nghi tiện lợi hơn)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh\'s family harvests their crops in ___.',
                    'options' => null,
                    'answer' => 'autumn',
                    'explanation_vi' => 'Minh nói: \'We harvest in autumn\' (Chúng tôi thu hoạch vào mùa thu)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Comparing Life in the Countryside and the City',
            'title_vi' => 'So sánh cuộc sống ở nông thôn và thành phố',
            'instructions_en' => 'Write a short paragraph comparing life in the countryside with life in the city. Use comparative adjectives and comparative structures to show the differences. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn so sánh cuộc sống ở nông thôn với cuộc sống ở thành phố. Sử dụng tính từ so sánh và các cấu trúc so sánh để chỉ ra những khác biệt. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about how the countryside differs from the city. Include:
- At least two differences using comparative adjectives (e.g., more peaceful, more crowded, fresher, simpler)
- At least one comparison using \'than\' or \'as...as\'
- At least one advantage or disadvantage of each place',
            'prompt_vi' => 'Viết về cách nông thôn khác với thành phố. Bao gồm:
- Ít nhất hai điểm khác biệt sử dụng tính từ so sánh (ví dụ: yên tĩnh hơn, đông đúc hơn, trong lành hơn, đơn giản hơn)
- Ít nhất một so sánh sử dụng \'than\' hoặc \'as...as\'
- Ít nhất một ưu điểm hoặc nhược điểm của mỗi nơi',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-3' => [
        'reading' => [
            'title_en' => 'Being a Teenager in Vietnam',
            'title_vi' => 'Là một thanh niên ở Việt Nam',
            'instructions_en' => 'Read the passage about teenagers and their challenges. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về các thanh niên và những thách thức của họ. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Being a teenager is not easy. Teenagers in Vietnam face a lot of pressure from school and family. They have many exams and homework every day. This stress can make them worried and not confident. However, teenagers should manage their time well. They ought to balance their study and free time. They had better relax after school by playing sports or meeting friends. Parents and teachers should support teenagers and give them good advice. With good support, teenagers can become responsible and confident young people.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What causes stress for teenagers in Vietnam?',
                    'options' => [
                        0 => 'School and family pressure',
                        1 => 'Playing sports',
                        2 => 'Meeting friends',
                        3 => 'Relaxing at home',
                    ],
                    'answer' => 'School and family pressure',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Teenagers in Vietnam face a lot of pressure from school and family.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should teenagers do to manage stress?',
                    'options' => [
                        0 => 'Do more homework',
                        1 => 'Take more exams',
                        2 => 'Balance their study and free time',
                        3 => 'Worry more',
                    ],
                    'answer' => 'Balance their study and free time',
                    'explanation_vi' => 'Đoạn văn nói \'They ought to balance their study and free time.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How can teenagers relax after school?',
                    'options' => [
                        0 => 'By doing more homework',
                        1 => 'By playing sports or meeting friends',
                        2 => 'By taking exams',
                        3 => 'By studying alone',
                    ],
                    'answer' => 'By playing sports or meeting friends',
                    'explanation_vi' => 'Đoạn văn nói \'They had better relax after school by playing sports or meeting friends.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'True or False: Parents and teachers should not support teenagers.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'Parents and teachers should support teenagers\' nên câu này là sai.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Teenagers should ___ their time well to manage stress.',
                    'options' => null,
                    'answer' => 'manage',
                    'explanation_vi' => 'Từ \'manage\' được dùng trong câu \'teenagers should manage their time well.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Advice for Teenagers',
            'title_vi' => 'Lời khuyên cho thanh niên',
            'instructions_en' => 'Listen to the conversation between Linh and her friend Minh. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại giữa Linh và bạn của cô ấy là Minh. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! You look worried today. What\'s wrong?
Minh: I have so much pressure from school. I have exams next week and lots of homework.
Linh: I understand. Being a teenager is a challenge. You should relax more and balance your time.
Minh: You\'re right. I\'m stressed about everything.
Linh: You ought to talk to your parents. They can support you. You had better sleep well too.
Minh: Thanks, Linh. You\'re a good friend. I feel more confident now.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why is Minh worried?',
                    'options' => [
                        0 => 'He has exams next week and lots of homework',
                        1 => 'He doesn\'t like his school',
                        2 => 'He has pressure from his friends',
                    ],
                    'answer' => 'He has exams next week and lots of homework',
                    'explanation_vi' => 'Minh nói: \'I have exams next week and lots of homework.\' (Tôi có kỳ thi tuần tới và rất nhiều bài tập về nhà.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh advise Minh to do?',
                    'options' => [
                        0 => 'Stop doing homework',
                        1 => 'Relax more and balance his time',
                        2 => 'Change schools',
                    ],
                    'answer' => 'Relax more and balance his time',
                    'explanation_vi' => 'Linh nói: \'You should relax more and balance your time.\' (Bạn nên thư giãn nhiều hơn và cân bằng thời gian của bạn.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Who can support Minh according to Linh?',
                    'options' => [
                        0 => 'His teachers',
                        1 => 'His parents',
                        2 => 'His classmates',
                    ],
                    'answer' => 'His parents',
                    'explanation_vi' => 'Linh nói: \'You ought to talk to your parents. They can support you.\' (Bạn nên nói chuyện với bố mẹ. Họ có thể hỗ trợ bạn.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh says: \'You had better ___ well too.\'',
                    'options' => null,
                    'answer' => 'sleep',
                    'explanation_vi' => 'Linh khuyên Minh nên ngủ đủ giấc. \'Had better\' là lời khuyên mạnh mẽ, và \'sleep well\' có nghĩa là ngủ đủ giấc.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Advice for a Busy Teenager',
            'title_vi' => 'Lời khuyên cho một thanh niên bận rộn',
            'instructions_en' => 'Write advice for a teenager who is worried about exams and homework. Use should, ought to, or had better to give at least 3 pieces of advice. Write 50-80 words.',
            'instructions_vi' => 'Viết lời khuyên cho một thanh niên lo lắng về kỳ thi và bài tập về nhà. Sử dụng should, ought to, hoặc had better để đưa ra ít nhất 3 lời khuyên. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Your friend Minh is a teenager with lots of pressure from exams and homework. He feels stressed and worried. Write advice to help him manage the pressure and feel more confident.

Include:
- At least one piece of advice using \'should\'
- At least one piece of advice using \'ought to\' or \'had better\'
- Advice about balancing school work and relaxing',
            'prompt_vi' => 'Bạn của bạn là Minh, một thanh niên có nhiều áp lực từ kỳ thi và bài tập về nhà. Anh ấy cảm thấy căng thẳng và lo lắng. Viết lời khuyên để giúp anh ấy quản lý áp lực và cảm thấy tự tin hơn.

Bao gồm:
- Ít nhất một lời khuyên sử dụng \'should\'
- Ít nhất một lời khuyên sử dụng \'ought to\' hoặc \'had better\'
- Lời khuyên về cân bằng giữa học tập và thư giãn',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-4' => [
        'reading' => [
            'title_en' => 'The Tay People of Northern Vietnam',
            'title_vi' => 'Dân tộc Tày ở miền Bắc Việt Nam',
            'instructions_en' => 'Read the passage about the Tay ethnic group. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về dân tộc Tày. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'The Tay are an ethnic group living in northern Vietnam. Their colorful costumes are made from cotton fabric and decorated with beautiful embroidery. Traditional patterns are woven into their clothes by skilled craftspeople. The Tay people celebrate many festivals during the year. The Spring Festival is celebrated by families who gather together to enjoy special food and music. Their unique customs and traditions are preserved through handicrafts like weaving and embroidery. These distinctive heritage items are sold in local markets. Young people learn these traditional skills from their parents to keep their culture alive.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where do the Tay ethnic group live?',
                    'options' => [
                        0 => 'Northern Vietnam',
                        1 => 'Southern Vietnam',
                        2 => 'Central Vietnam',
                        3 => 'Ho Chi Minh City',
                    ],
                    'answer' => 'Northern Vietnam',
                    'explanation_vi' => 'Đoạn văn nói rõ \'The Tay are an ethnic group living in northern Vietnam.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What materials are used to make Tay costumes?',
                    'options' => [
                        0 => 'Silk and gold',
                        1 => 'Cotton fabric and embroidery',
                        2 => 'Wool and leather',
                        3 => 'Plastic and paint',
                    ],
                    'answer' => 'Cotton fabric and embroidery',
                    'explanation_vi' => 'Đoạn văn nói \'Their colorful costumes are made from cotton fabric and decorated with beautiful embroidery.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Who learns traditional Tay skills?',
                    'options' => [
                        0 => 'Only old people',
                        1 => 'Only teachers',
                        2 => 'Young people from their parents',
                        3 => 'Only tourists',
                    ],
                    'answer' => 'Young people from their parents',
                    'explanation_vi' => 'Đoạn văn nói \'Young people learn these traditional skills from their parents to keep their culture alive.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Traditional patterns are woven into Tay clothes by skilled craftspeople.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Traditional patterns are woven into their clothes by skilled craftspeople.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The Tay people celebrate many ___ during the year.',
                    'options' => null,
                    'answer' => 'festivals',
                    'explanation_vi' => 'Từ \'festivals\' xuất hiện trong câu này của đoạn văn.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'The Tày Ethnic Group',
            'title_vi' => 'Dân tộc Tày',
            'instructions_en' => 'Listen to the conversation about the Tày ethnic group. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc trò chuyện về dân tộc Tày. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! Do you know about the Tày ethnic group?
Minh: Yes! The Tày people live in northern Việt Nam. Their costumes are made from colorful fabric.
Linh: That\'s right. The embroidery on their clothes is very beautiful and unique.
Minh: I agree. Their traditions are celebrated by the whole community during festivals.
Linh: Their handicrafts are very distinctive. Baskets and cloth are woven by skilled workers.
Minh: Yes, and their heritage is preserved by young people today.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where do the Tày people live?',
                    'options' => [
                        0 => 'In southern Việt Nam',
                        1 => 'In northern Việt Nam',
                        2 => 'In central Việt Nam',
                    ],
                    'answer' => 'In northern Việt Nam',
                    'explanation_vi' => 'Minh nói \'The Tày people live in northern Việt Nam\' - dân tộc Tày sống ở miền bắc Việt Nam.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What are Tày costumes made from?',
                    'options' => [
                        0 => 'White fabric',
                        1 => 'Colorful fabric',
                        2 => 'Silk fabric',
                    ],
                    'answer' => 'Colorful fabric',
                    'explanation_vi' => 'Minh nói \'Their costumes are made from colorful fabric\' - trang phục của họ được làm từ vải đầy màu sắc.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Who preserves the Tày heritage?',
                    'options' => [
                        0 => 'Old people only',
                        1 => 'Young people today',
                        2 => 'Foreigners',
                    ],
                    'answer' => 'Young people today',
                    'explanation_vi' => 'Minh nói \'their heritage is preserved by young people today\' - di sản của họ được bảo tồn bởi những người trẻ ngày nay.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Baskets and cloth are ___ by skilled workers.',
                    'options' => null,
                    'answer' => 'woven',
                    'explanation_vi' => 'Linh nói \'Baskets and cloth are woven by skilled workers\' - giỏ và vải được dệt bởi những công nhân lành nghề. \'Woven\' là dạng bị động của \'weave\'.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Writing about an Ethnic Group\'s Traditions',
            'title_vi' => 'Viết về truyền thống của một dân tộc',
            'instructions_en' => 'Write a short paragraph (50-80 words) about an ethnic group in Viet Nam. Use the present simple passive voice to describe how their costumes, handicrafts, or festivals are made or celebrated. You can write about the Tày, Thái, Muong, Hmong, or any ethnic group you know.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) về một dân tộc ở Việt Nam. Sử dụng thể bị động ở hiện tại đơn để mô tả cách trang phục, thủ công mỹ nghệ hoặc lễ hội của họ được làm hoặc tổ chức. Bạn có thể viết về dân tộc Tày, Thái, Muong, Hmong hoặc bất kỳ dân tộc nào bạn biết.',
            'passage' => null,
            'prompt_en' => 'Write about one ethnic group in Viet Nam. Include:
- The name of the ethnic group and one of their traditions or customs
- How their costumes or handicrafts are made (use passive voice: \'are made from...\', \'are woven...\', \'are embroidered with...\')
- Why this tradition is important to preserve their heritage',
            'prompt_vi' => 'Viết về một dân tộc ở Việt Nam. Bao gồm:
- Tên dân tộc và một truyền thống hoặc phong tục của họ
- Cách trang phục hoặc thủ công mỹ nghệ của họ được làm (sử dụng thể bị động: \'are made from...\', \'are woven...\', \'are embroidered with...\')
- Tại sao truyền thống này rất quan trọng để bảo tồn di sản của họ',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-5' => [
        'reading' => [
            'title_en' => 'Tet Traditions in Vietnam',
            'title_vi' => 'Phong tục Tết ở Việt Nam',
            'instructions_en' => 'Read the passage about Tet traditions. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về phong tục Tết. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Tet is the most important festival in Vietnam. It is a lunar celebration when families gather together for reunion. During Tet, people should clean their homes and decorate with flowers. Children must respect their parents and grandparents by greeting them politely. Families ought to worship their ancestors and visit the pagoda. Many people prepare special food like bánh chưng and give lucky money to children. These customs and traditions must be passed down to the next generation. Tet helps Vietnamese people remember their culture and family values.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should people do during Tet according to the passage?',
                    'options' => [
                        0 => 'Clean their homes and decorate with flowers',
                        1 => 'Stay at home alone',
                        2 => 'Go shopping at the market',
                        3 => 'Sleep all day',
                    ],
                    'answer' => 'Clean their homes and decorate with flowers',
                    'explanation_vi' => 'Đoạn văn nói rõ: \'people should clean their homes and decorate with flowers.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why must children respect their parents during Tet?',
                    'options' => [
                        0 => 'Because they want money',
                        1 => 'Because it is a custom and tradition',
                        2 => 'Because the passage does not explain why',
                        3 => 'Because they are tired',
                    ],
                    'answer' => 'Because it is a custom and tradition',
                    'explanation_vi' => 'Đoạn văn nói về phong tục và truyền thống, và đó là lý do tại sao trẻ em phải tôn trọng cha mẹ.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What ought families to do during Tet?',
                    'options' => [
                        0 => 'Worship their ancestors and visit the pagoda',
                        1 => 'Go to work',
                        2 => 'Watch television',
                        3 => 'Play games outside',
                    ],
                    'answer' => 'Worship their ancestors and visit the pagoda',
                    'explanation_vi' => 'Đoạn văn nói: \'Families ought to worship their ancestors and visit the pagoda.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Tet is a lunar celebration when families gather for reunion.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói rõ: \'It is a lunar celebration when families gather together for reunion.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'These customs and traditions must be ___ to the next generation.',
                    'options' => null,
                    'answer' => 'passed down',
                    'explanation_vi' => 'Đoạn văn nói: \'These customs and traditions must be passed down to the next generation.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Vietnamese Tet Customs',
            'title_vi' => 'Phong tục Tết Việt Nam',
            'instructions_en' => 'Listen to the conversation about Tet traditions. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về truyền thống Tết. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! Do you celebrate Tet with your family?
Minh: Yes, I do! Tet is a very important festival in Vietnam. We must gather together and respect our ancestors.
Linh: What should we do during Tet?
Minh: We ought to worship our ancestors and clean our house. We should also pass down our customs to the next generation.
Linh: That sounds wonderful! Is Tet a lunar festival?
Minh: Yes! Tet is the lunar new year. It is a time for family reunion and celebration.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What must Minh\'s family do during Tet?',
                    'options' => [
                        0 => 'They must gather together and respect their ancestors.',
                        1 => 'They must travel to another city.',
                        2 => 'They must work in the garden.',
                    ],
                    'answer' => 'They must gather together and respect their ancestors.',
                    'explanation_vi' => 'Minh nói: \'We must gather together and respect our ancestors.\' (Chúng tôi phải tập hợp lại và tôn trọng tổ tiên của mình.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should people do to pass down customs?',
                    'options' => [
                        0 => 'They should forget old traditions.',
                        1 => 'They should pass down customs to the next generation.',
                        2 => 'They should only celebrate alone.',
                    ],
                    'answer' => 'They should pass down customs to the next generation.',
                    'explanation_vi' => 'Minh nói: \'We should also pass down our customs to the next generation.\' (Chúng ta cũng nên truyền lại phong tục của mình cho thế hệ tiếp theo.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Is Tet a lunar festival?',
                    'options' => [
                        0 => 'No, Tet is not a festival.',
                        1 => 'Yes, Tet is the lunar new year.',
                        2 => 'No, Tet is a Western festival.',
                    ],
                    'answer' => 'Yes, Tet is the lunar new year.',
                    'explanation_vi' => 'Minh trả lời: \'Yes! Tet is the lunar new year.\' (Đúng! Tết là năm mới âm lịch.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'During Tet, people ought to ___ their ancestors.',
                    'options' => null,
                    'answer' => 'worship',
                    'explanation_vi' => 'Minh nói: \'We ought to worship our ancestors.\' (Chúng ta nên thờ cúng tổ tiên của mình.)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Writing about Vietnamese Customs and What We Should Do',
            'title_vi' => 'Viết về phong tục Việt Nam và những gì chúng ta nên làm',
            'instructions_en' => 'Write a short paragraph (50-80 words) about a Vietnamese custom or tradition. Use modal verbs (should, must, ought to) to explain what people should do to respect this custom. Use at least 3 words from the unit vocabulary.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) về một phong tục hoặc truyền thống Việt Nam. Sử dụng các động từ khiếm khuyết (should, must, ought to) để giải thích những gì mọi người nên làm để tôn trọng phong tục này. Sử dụng ít nhất 3 từ từ vựng của bài học.',
            'passage' => null,
            'prompt_en' => 'Choose one Vietnamese custom or tradition (for example: Tet celebration, family reunion, worshipping ancestors, or another custom you know). Write about it and explain:
- What this custom or tradition is and when people celebrate it
- What people should do or must do to follow this custom
- Why this custom is important and how it passes down to the next generation',
            'prompt_vi' => 'Chọn một phong tục hoặc truyền thống Việt Nam (ví dụ: lễ Tết, đoàn tụ gia đình, thờ cúng tổ tiên, hoặc một phong tục khác bạn biết). Viết về nó và giải thích:
- Phong tục hoặc truyền thống này là gì và khi nào mọi người kỷ niệm nó
- Mọi người nên làm gì hoặc phải làm gì để tuân theo phong tục này
- Tại sao phong tục này quan trọng và nó được truyền lại cho thế hệ tiếp theo như thế nào',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-6' => [
        'reading' => [
            'title_en' => 'Two Different Lifestyles',
            'title_vi' => 'Hai Lối Sống Khác Nhau',
            'instructions_en' => 'Read the passage about two friends and their lifestyles. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về lối sống của hai bạn. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh and Lan are best friends, but their lifestyles are very different. Minh has a healthy lifestyle. He exercises every day and eats a balanced diet with lots of vegetables and fruit. He sleeps eight hours every night and has a good routine. Minh feels less stress than Lan because he relaxes after school.

Lan has an unhealthy lifestyle. She exercises only two times a week. Her diet is not balanced – she eats more fast food than healthy food. Lan sleeps only six hours every night, so she feels very tired. She wants to change her habits and improve her lifestyle. Lan thinks Minh\'s lifestyle is the healthiest and the best.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many hours does Minh sleep every night?',
                    'options' => [
                        0 => 'six hours',
                        1 => 'seven hours',
                        2 => 'eight hours',
                        3 => 'nine hours',
                    ],
                    'answer' => 'eight hours',
                    'explanation_vi' => 'Đoạn văn nói \'He sleeps eight hours every night.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh do to relax after school?',
                    'options' => [
                        0 => 'He eats fast food',
                        1 => 'He plays video games',
                        2 => 'He relaxes',
                        3 => 'He watches TV',
                    ],
                    'answer' => 'He relaxes',
                    'explanation_vi' => 'Đoạn văn nói \'he relaxes after school\' để giảm căng thẳng.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Whose lifestyle is healthier – Minh\'s or Lan\'s?',
                    'options' => [
                        0 => 'Lan\'s lifestyle',
                        1 => 'Minh\'s lifestyle',
                        2 => 'They are the same',
                        3 => 'We don\'t know',
                    ],
                    'answer' => 'Minh\'s lifestyle',
                    'explanation_vi' => 'Minh có lối sống lành mạnh, Lan có lối sống không lành mạnh, nên Minh khỏe hơn.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Lan exercises every day.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói Lan \'exercises only two times a week\', không phải mỗi ngày.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Lan wants to ___ her lifestyle and improve her habits.',
                    'options' => null,
                    'answer' => 'change',
                    'explanation_vi' => 'Câu trong đoạn văn là \'She wants to change her habits and improve her lifestyle.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Comparing Lifestyles',
            'title_vi' => 'So sánh lối sống',
            'instructions_en' => 'Listen to the conversation about two friends\' lifestyles. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về lối sống của hai bạn. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! How is your lifestyle these days?
Minh: Hi Linh! It\'s different from before. I exercise more now.
Linh: That\'s great! What about your diet?
Minh: My diet is more balanced. I eat more vegetables and less fast food.
Linh: Do you sleep better?
Minh: Yes! I sleep eight hours every night. I have less stress and I relax more.
Linh: Your routine is healthier than mine! I need to change my habits.
Minh: You can improve your lifestyle too. It\'s not difficult!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Minh do more now?',
                    'options' => [
                        0 => 'He sleeps more',
                        1 => 'He exercises more',
                        2 => 'He eats more fast food',
                    ],
                    'answer' => 'He exercises more',
                    'explanation_vi' => 'Minh nói \'I exercise more now\' - anh ấy tập thể dục nhiều hơn bây giờ.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many hours does Minh sleep every night?',
                    'options' => [
                        0 => 'Six hours',
                        1 => 'Seven hours',
                        2 => 'Eight hours',
                    ],
                    'answer' => 'Eight hours',
                    'explanation_vi' => 'Minh nói \'I sleep eight hours every night\' - anh ấy ngủ tám giờ mỗi đêm.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Whose routine is healthier?',
                    'options' => [
                        0 => 'Linh\'s routine',
                        1 => 'Minh\'s routine',
                        2 => 'They are the same',
                    ],
                    'answer' => 'Minh\'s routine',
                    'explanation_vi' => 'Linh nói \'Your routine is healthier than mine!\' - lối sống của Minh lành mạnh hơn của Linh.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh eats more vegetables and less ___.',
                    'options' => null,
                    'answer' => 'fast food',
                    'explanation_vi' => 'Minh nói \'I eat more vegetables and less fast food\' - anh ấy ăn ít đồ ăn nhanh hơn.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Compare Two Lifestyles',
            'title_vi' => 'So sánh hai lối sống',
            'instructions_en' => 'Write a short paragraph comparing the lifestyles of two people. Use comparative adjectives (more/less + adjective or -er) and at least one superlative to show differences and similarities. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn so sánh lối sống của hai người. Sử dụng tính từ so sánh (more/less + tính từ hoặc -er) và ít nhất một tính từ so sánh nhất để chỉ ra sự khác nhau và giống nhau. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Compare the lifestyles of Minh and Lan. Include:
- Their daily routines and habits (exercise, sleep, diet)
- At least two comparative sentences (e.g., \'Minh is more active than Lan\' or \'Lan sleeps less than Minh\')
- One superlative sentence (e.g., \'Minh has the healthiest diet\')',
            'prompt_vi' => 'So sánh lối sống của Minh và Lan. Bao gồm:
- Thói quen hàng ngày và thói quen của họ (tập thể dục, ngủ, chế độ ăn)
- Ít nhất hai câu so sánh (ví dụ: \'Minh năng động hơn Lan\' hoặc \'Lan ngủ ít hơn Minh\')
- Một câu so sánh nhất (ví dụ: \'Minh có chế độ ăn lành mạnh nhất\')',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-7' => [
        'reading' => [
            'title_en' => 'Protecting Our Environment',
            'title_vi' => 'Bảo vệ môi trường của chúng ta',
            'instructions_en' => 'Read the passage about environmental protection. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về bảo vệ môi trường. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Our environment is in danger. Air pollution and water pollution are serious problems in many cities. We should reduce plastic waste and recycle more. We ought to reuse bags and bottles instead of throwing them away. Deforestation is destroying forests, and many animals are endangered. We should protect forests and use renewable energy like solar power. Climate change is getting worse, so we need sustainable solutions. Everyone should help protect our environment for the future.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What are two serious problems mentioned in the passage?',
                    'options' => [
                        0 => 'Air pollution and water pollution',
                        1 => 'Plastic bags and bottles',
                        2 => 'Solar power and renewable energy',
                        3 => 'Forests and animals',
                    ],
                    'answer' => 'Air pollution and water pollution',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Air pollution and water pollution are serious problems in many cities.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should we do with plastic waste?',
                    'options' => [
                        0 => 'Throw it in the river',
                        1 => 'Reduce and recycle it',
                        2 => 'Burn it in the forest',
                        3 => 'Leave it on the street',
                    ],
                    'answer' => 'Reduce and recycle it',
                    'explanation_vi' => 'Đoạn văn nói \'We should reduce plastic waste and recycle more.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why are many animals endangered?',
                    'options' => [
                        0 => 'Because of renewable energy',
                        1 => 'Because of climate change only',
                        2 => 'Because of deforestation',
                        3 => 'Because of recycling',
                    ],
                    'answer' => 'Because of deforestation',
                    'explanation_vi' => 'Đoạn văn nói \'Deforestation is destroying forests, and many animals are endangered.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'We ought to reuse bags and bottles instead of throwing them away.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói rõ \'We ought to reuse bags and bottles instead of throwing them away.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'We should use ___ like solar power to protect the environment.',
                    'options' => null,
                    'answer' => 'renewable energy',
                    'explanation_vi' => 'Đoạn văn nói \'use renewable energy like solar power.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Protecting Our Environment',
            'title_vi' => 'Bảo vệ môi trường của chúng ta',
            'instructions_en' => 'Listen to the conversation between Linh and her teacher. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại giữa Linh và cô giáo của cô ấy. Sau đó trả lời các câu hỏi.',
            'passage' => 'Teacher: Linh, what do you think about pollution in our environment?
Linh: I think air pollution and water pollution are very serious problems, teacher.
Teacher: You are right. So what should we do to protect our environment?
Linh: We should reduce plastic waste. We ought to recycle and reuse things.
Teacher: Excellent! We should also use renewable energy and protect our forests from deforestation.
Linh: Yes, teacher. I want to help save endangered animals too.
Teacher: That\'s wonderful, Linh. If we all work together, we can make our environment more sustainable.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What are the two types of pollution that Linh mentions?',
                    'options' => [
                        0 => 'air pollution and water pollution',
                        1 => 'plastic pollution and forest pollution',
                        2 => 'waste pollution and climate change',
                    ],
                    'answer' => 'air pollution and water pollution',
                    'explanation_vi' => 'Linh nói: \'I think air pollution and water pollution are very serious problems\' (Tôi nghĩ ô nhiễm không khí và ô nhiễm nước là những vấn đề rất nghiêm trọng)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should we do to protect the environment according to the teacher?',
                    'options' => [
                        0 => 'We should only recycle plastic',
                        1 => 'We should use renewable energy and protect forests from deforestation',
                        2 => 'We should stop using water',
                    ],
                    'answer' => 'We should use renewable energy and protect forests from deforestation',
                    'explanation_vi' => 'Cô giáo nói: \'We should also use renewable energy and protect our forests from deforestation\' (Chúng ta cũng nên sử dụng năng lượng tái tạo và bảo vệ rừng của chúng ta khỏi phá rừng)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh want to help save?',
                    'options' => [
                        0 => 'plastic waste',
                        1 => 'renewable energy',
                        2 => 'endangered animals',
                    ],
                    'answer' => 'endangered animals',
                    'explanation_vi' => 'Linh nói: \'I want to help save endangered animals too\' (Tôi cũng muốn giúp cứu các loài động vật nguy cấp)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'We ought to ___ and ___ things to reduce waste.',
                    'options' => null,
                    'answer' => 'recycle and reuse',
                    'explanation_vi' => 'Linh nói: \'We ought to recycle and reuse things\' (Chúng ta nên tái chế và tái sử dụng những thứ)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Give Environmental Advice',
            'title_vi' => 'Đưa ra lời khuyên về bảo vệ môi trường',
            'instructions_en' => 'Write a short paragraph giving advice about how to protect the environment. Use \'should\' or \'ought to\' with the verbs provided. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn đưa ra lời khuyên về cách bảo vệ môi trường. Sử dụng \'should\' hoặc \'ought to\' với các động từ được cung cấp. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Imagine you are writing advice for your classmates about protecting the environment. Include:
- At least two things people should do to reduce pollution (use: reduce, recycle, reuse, or protect)
- One reason why this is important (mention: air pollution, water pollution, endangered animals, or climate change)
- One action using renewable energy or sustainable practices',
            'prompt_vi' => 'Hãy tưởng tượng bạn đang viết lời khuyên cho các bạn cùng lớp về bảo vệ môi trường. Bao gồm:
- Ít nhất hai điều mà mọi người nên làm để giảm ô nhiễm (sử dụng: reduce, recycle, reuse, hoặc protect)
- Một lý do tại sao điều này quan trọng (đề cập: air pollution, water pollution, endangered animals, hoặc climate change)
- Một hành động sử dụng năng lượng tái tạo hoặc thực hành bền vững',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-8' => [
        'reading' => [
            'title_en' => 'Shopping at Trang\'s Clothing Shop',
            'title_vi' => 'Mua sắm tại cửa hàng quần áo của Trang',
            'instructions_en' => 'Read the passage about Linh\'s shopping experience. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về kinh nghiệm mua sắm của Linh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh goes to Trang\'s shop on Nguyen Hue Street. She wants to buy a new shirt. The shop has many colors: red, blue, and white. Linh asks the shop assistant, "How much does this blue shirt cost?" The assistant says, "It costs 150,000 dong. The quality is very good." Linh asks to try on the shirt. The size is medium and it fits perfectly. The material is cotton. Linh is happy with the shirt. She pays with cash and gets a receipt. Today there is a 10% discount, so she pays only 135,000 dong.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What color shirt does Linh want to buy?',
                    'options' => [
                        0 => 'Red',
                        1 => 'Blue',
                        2 => 'White',
                        3 => 'Green',
                    ],
                    'answer' => 'Blue',
                    'explanation_vi' => 'Đoạn văn nói Linh hỏi "How much does this blue shirt cost?"',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is the original price of the shirt?',
                    'options' => [
                        0 => '135,000 dong',
                        1 => '150,000 dong',
                        2 => '160,000 dong',
                        3 => '125,000 dong',
                    ],
                    'answer' => '150,000 dong',
                    'explanation_vi' => 'Nhân viên bán hàng nói "It costs 150,000 dong."',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What material is the shirt made of?',
                    'options' => [
                        0 => 'Silk',
                        1 => 'Wool',
                        2 => 'Cotton',
                        3 => 'Polyester',
                    ],
                    'answer' => 'Cotton',
                    'explanation_vi' => 'Đoạn văn nói "The material is cotton."',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Linh pays with a credit card.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói Linh trả tiền bằng tiền mặt (pays with cash), không phải thẻ tín dụng.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The size is medium and it ___ perfectly.',
                    'options' => null,
                    'answer' => 'fits',
                    'explanation_vi' => 'Đoạn văn nói "The size is medium and it fits perfectly."',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'At the Clothing Shop',
            'title_vi' => 'Tại cửa hàng quần áo',
            'instructions_en' => 'Listen to the conversation between a customer and a shop assistant. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại giữa khách hàng và nhân viên cửa hàng. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Shop assistant: Hello! Welcome to our shop. Can I help you?
Customer: Yes, thank you. How much does this blue shirt cost?
Shop assistant: It costs 250,000 dong. The quality is very good.
Customer: Can I try it on? What size is it?
Shop assistant: Of course! It is size M. The fitting room is over there.
Customer: Great! Do you have a discount today?
Shop assistant: Yes, we have 20% discount on all shirts. You pay only 200,000 dong.
Customer: Perfect! I will buy it. Can I pay by cash?
Shop assistant: Yes, you can. Here is your receipt.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is the original price of the blue shirt?',
                    'options' => [
                        0 => '200,000 dong',
                        1 => '250,000 dong',
                        2 => '300,000 dong',
                    ],
                    'answer' => '250,000 dong',
                    'explanation_vi' => 'Nhân viên cửa hàng nói: \'It costs 250,000 dong\' (Nó có giá 250,000 đồng)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What size is the shirt?',
                    'options' => [
                        0 => 'Size S',
                        1 => 'Size M',
                        2 => 'Size L',
                    ],
                    'answer' => 'Size M',
                    'explanation_vi' => 'Nhân viên cửa hàng nói: \'It is size M\' (Nó là kích cỡ M)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How much discount does the shop have today?',
                    'options' => [
                        0 => '10% discount',
                        1 => '15% discount',
                        2 => '20% discount',
                    ],
                    'answer' => '20% discount',
                    'explanation_vi' => 'Nhân viên cửa hàng nói: \'we have 20% discount on all shirts\' (chúng tôi có giảm giá 20% cho tất cả các áo sơ mi)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The customer wants to ___ the shirt before buying it.',
                    'options' => null,
                    'answer' => 'try on',
                    'explanation_vi' => 'Khách hàng hỏi: \'Can I try it on?\' (Tôi có thể thử nó không?)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'A Conversation at a Clothing Shop',
            'title_vi' => 'Một cuộc trò chuyện tại cửa hàng quần áo',
            'instructions_en' => 'Write a short dialogue between a customer and a shop assistant. Use the grammar points and vocabulary from this unit. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn hội thoại ngắn giữa khách hàng và nhân viên cửa hàng. Sử dụng cấu trúc ngữ pháp và từ vựng từ bài học này. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Imagine you are shopping for a new shirt at a clothing shop in Hà Nội. Write a dialogue where you:
- Ask about the price and size of a shirt
- Ask to try it on
- Ask about the color or material
- Ask about a discount or decide to pay',
            'prompt_vi' => 'Tưởng tượng bạn đang mua một chiếc áo sơ mi mới tại một cửa hàng quần áo ở Hà Nội. Viết một đoạn hội thoại trong đó bạn:
- Hỏi giá cả và kích cỡ của chiếc áo
- Xin thử áo
- Hỏi về màu sắc hoặc chất liệu
- Hỏi về giảm giá hoặc quyết định trả tiền',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-9' => [
        'reading' => [
            'title_en' => 'Safety During Natural Disasters',
            'title_vi' => 'An toàn trong các thiên tai',
            'instructions_en' => 'Read the passage about natural disasters and answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về các thiên tai và trả lời các câu hỏi dưới đây.',
            'passage' => 'Vietnam often faces dangerous natural disasters like floods, storms, and earthquakes. When a typhoon comes, people must prepare their homes and families. They should stay indoors and avoid going outside during heavy rain and lightning. Thunder and strong wind can be very dangerous. Families must evacuate to a safe shelter if the government warns them. During an emergency, you should listen to the radio for information. Children must stay with their parents and follow their instructions. People should keep emergency supplies like water and food at home. Being prepared helps families stay safe during natural disasters.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should people do during heavy rain and lightning?',
                    'options' => [
                        0 => 'Stay indoors and avoid going outside',
                        1 => 'Go outside to watch the storm',
                        2 => 'Play in the wind',
                        3 => 'Ignore the thunder',
                    ],
                    'answer' => 'Stay indoors and avoid going outside',
                    'explanation_vi' => 'Đoạn văn nói rõ \'They should stay indoors and avoid going outside during heavy rain and lightning.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'When must families evacuate to a shelter?',
                    'options' => [
                        0 => 'When it is sunny',
                        1 => 'When the government warns them',
                        2 => 'When they want to',
                        3 => 'Every day',
                    ],
                    'answer' => 'When the government warns them',
                    'explanation_vi' => 'Đoạn văn nói \'Families must evacuate to a safe shelter if the government warns them.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What emergency supplies should people keep at home?',
                    'options' => [
                        0 => 'Toys and games',
                        1 => 'Water and food',
                        2 => 'Books and pens',
                        3 => 'Clothes and shoes',
                    ],
                    'answer' => 'Water and food',
                    'explanation_vi' => 'Đoạn văn nói \'People should keep emergency supplies like water and food at home.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Thunder and strong wind can be very dangerous.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Thunder and strong wind can be very dangerous.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'During an emergency, you should listen to the ___ for information.',
                    'options' => null,
                    'answer' => 'radio',
                    'explanation_vi' => 'Đoạn văn nói \'During an emergency, you should listen to the radio for information.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Before the Storm',
            'title_vi' => 'Trước cơn bão',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe nó hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh: Hi Linh! Have you heard the weather warning? There is a big typhoon coming tomorrow.
Linh: Oh no! What should we do?
Minh: We must prepare now. We should stay indoors and avoid going outside.
Linh: That\'s right. The wind and heavy rain will be very dangerous.
Minh: Yes. We must find a safe shelter. My family will evacuate to my grandmother\'s house in the city.
Linh: Good idea. I will warn my neighbors about the emergency too.
Minh: That\'s very kind of you!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is coming tomorrow?',
                    'options' => [
                        0 => 'A storm',
                        1 => 'A typhoon',
                        2 => 'Heavy rain',
                    ],
                    'answer' => 'A typhoon',
                    'explanation_vi' => 'Minh nói \'There is a big typhoon coming tomorrow\' (Có một cơn bão lớn sắp tới ngày mai).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where will Minh\'s family evacuate to?',
                    'options' => [
                        0 => 'To a shelter',
                        1 => 'To the city',
                        2 => 'To grandmother\'s house in the city',
                    ],
                    'answer' => 'To grandmother\'s house in the city',
                    'explanation_vi' => 'Minh nói \'My family will evacuate to my grandmother\'s house in the city\' (Gia đình tôi sẽ sơ tán đến nhà bà tôi ở thành phố).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should people do during the typhoon?',
                    'options' => [
                        0 => 'Go outside and play',
                        1 => 'Stay indoors and avoid going outside',
                        2 => 'Prepare food only',
                    ],
                    'answer' => 'Stay indoors and avoid going outside',
                    'explanation_vi' => 'Minh nói \'We should stay indoors and avoid going outside\' (Chúng ta nên ở trong nhà và tránh đi ra ngoài).',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'We ___ find a safe shelter before the typhoon arrives.',
                    'options' => null,
                    'answer' => 'must',
                    'explanation_vi' => 'Minh nói \'We must find a safe shelter\' (Chúng ta phải tìm một nơi trú ẩn an toàn). \'Must\' được dùng để chỉ sự bắt buộc.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Safety Tips During a Natural Disaster',
            'title_vi' => 'Mẹo An Toàn Khi Có Thiên Tai',
            'instructions_en' => 'Write a short text giving safety advice for one natural disaster. Use should/must to give advice and obligations. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn về lời khuyên an toàn cho một thiên tai. Sử dụng should/must để đưa ra lời khuyên và bắt buộc. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Choose one natural disaster (storm, flood, earthquake, or typhoon). Write advice for people in that emergency situation. Include:
- What people should do to stay safe
- What people must avoid
- Where they should go or what shelter they should find',
            'prompt_vi' => 'Chọn một thiên tai (bão, lũ lụt, động đất, hoặc bão lớn). Viết lời khuyên cho mọi người trong tình huống khẩn cấp đó. Bao gồm:
- Mọi người nên làm gì để an toàn
- Mọi người phải tránh cái gì
- Họ nên đi đâu hoặc tìm nơi trú ẩn nào',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-10' => [
        'reading' => [
            'title_en' => 'Communication in the Future',
            'title_vi' => 'Giao tiếp trong tương lai',
            'instructions_en' => 'Read the passage about how people will communicate in the future. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về cách mọi người sẽ giao tiếp trong tương lai. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'In the future, technology will change how we communicate. People will use virtual devices and holograms to talk with friends and family far away. Artificial intelligence will translate languages in real-time, so language will not be a barrier anymore. Some scientists believe that brain chips will connect our minds directly, and telepathy will be possible. Wireless technology will become more advanced. Communication will be instant and easy for everyone. We will have many new ways to connect with each other.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What will artificial intelligence do in the future?',
                    'options' => [
                        0 => 'It will translate languages in real-time',
                        1 => 'It will create holograms for communication',
                        2 => 'It will replace all wireless devices',
                        3 => 'It will teach people new languages',
                    ],
                    'answer' => 'It will translate languages in real-time',
                    'explanation_vi' => 'Đoạn văn nói rõ: \'Artificial intelligence will translate languages in real-time\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the passage, what will brain chips do?',
                    'options' => [
                        0 => 'They will make wireless technology faster',
                        1 => 'They will connect our minds directly',
                        2 => 'They will create virtual devices',
                        3 => 'They will translate all languages',
                    ],
                    'answer' => 'They will connect our minds directly',
                    'explanation_vi' => 'Đoạn văn nói: \'brain chips will connect our minds directly\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why will language not be a barrier in the future?',
                    'options' => [
                        0 => 'Because everyone will speak the same language',
                        1 => 'Because artificial intelligence will translate languages in real-time',
                        2 => 'Because brain chips will teach us new languages',
                        3 => 'Because wireless technology will be advanced',
                    ],
                    'answer' => 'Because artificial intelligence will translate languages in real-time',
                    'explanation_vi' => 'Đoạn văn giải thích: \'Artificial intelligence will translate languages in real-time, so language will not be a barrier anymore\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'People will use holograms to communicate with people far away.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói: \'People will use virtual devices and holograms to talk with friends and family far away\'.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'In the future, communication will be ___ and easy for everyone.',
                    'options' => null,
                    'answer' => 'instant',
                    'explanation_vi' => 'Câu cuối cùng của đoạn văn nói: \'Communication will be instant and easy for everyone\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Communication in the Future',
            'title_vi' => 'Giao tiếp trong tương lai',
            'instructions_en' => 'Listen to the conversation about future communication technology. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại về công nghệ giao tiếp trong tương lai. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh: Hi Linh! Do you think communication will change in the future?
Linh: Yes, Minh. I think we will use virtual reality to communicate with people far away.
Minh: That sounds interesting! Will we use holograms?
Linh: Definitely! We will see holograms of people in real-time. It will be like they are in the room with us.
Minh: What about language barriers?
Linh: Artificial intelligence will translate languages instantly. Communication will be wireless and instant. No more barriers!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh think we will use to communicate with people far away?',
                    'options' => [
                        0 => 'Brain chips',
                        1 => 'Virtual reality',
                        2 => 'Telepathy',
                    ],
                    'answer' => 'Virtual reality',
                    'explanation_vi' => 'Linh nói: \'I think we will use virtual reality to communicate with people far away.\' (Tôi nghĩ chúng ta sẽ sử dụng thực tế ảo để giao tiếp với những người ở xa.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the conversation, how will artificial intelligence help communication?',
                    'options' => [
                        0 => 'It will create holograms',
                        1 => 'It will translate languages instantly',
                        2 => 'It will connect wireless devices',
                    ],
                    'answer' => 'It will translate languages instantly',
                    'explanation_vi' => 'Linh nói: \'Artificial intelligence will translate languages instantly.\' (Trí tuệ nhân tạo sẽ dịch các ngôn ngữ tức thì.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What will holograms allow us to do?',
                    'options' => [
                        0 => 'Travel to other countries',
                        1 => 'See people in real-time as if they are in the room with us',
                        2 => 'Understand different languages',
                    ],
                    'answer' => 'See people in real-time as if they are in the room with us',
                    'explanation_vi' => 'Linh nói: \'We will see holograms of people in real-time. It will be like they are in the room with us.\' (Chúng ta sẽ thấy hình ảnh ba chiều của mọi người theo thời gian thực. Nó sẽ giống như họ đang ở trong phòng với chúng ta.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Communication will be ___ and instant.',
                    'options' => null,
                    'answer' => 'wireless',
                    'explanation_vi' => 'Linh nói: \'Communication will be wireless and instant.\' (Giao tiếp sẽ không dây và tức thì.)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Communication in 2050',
            'title_vi' => 'Giao tiếp năm 2050',
            'instructions_en' => 'Write about how people will communicate in the future. Use \'will + verb\' to make predictions. Include at least 3 new technologies from the unit vocabulary.',
            'instructions_vi' => 'Viết về cách mọi người sẽ giao tiếp trong tương lai. Sử dụng \'will + verb\' để đưa ra dự đoán. Bao gồm ít nhất 3 công nghệ mới từ từ vựng của bài học.',
            'passage' => null,
            'prompt_en' => 'Imagine life in 2050. Write about how communication technology will change. Include:
- At least two predictions about future communication devices or technology
- How these technologies will help people connect or remove barriers
- Your opinion: will these changes be good or bad?',
            'prompt_vi' => 'Tưởng tượng cuộc sống năm 2050. Viết về cách công nghệ giao tiếp sẽ thay đổi. Bao gồm:
- Ít nhất hai dự đoán về các thiết bị hoặc công nghệ giao tiếp trong tương lai
- Cách những công nghệ này sẽ giúp mọi người kết nối hoặc loại bỏ rào cản
- Ý kiến của bạn: những thay đổi này sẽ tốt hay xấu?',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-11' => [
        'reading' => [
            'title_en' => 'Great Inventions That Changed Our Lives',
            'title_vi' => 'Những phát minh vĩ đại thay đổi cuộc sống của chúng ta',
            'instructions_en' => 'Read the passage about important inventions and technology. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về những phát minh quan trọng và công nghệ. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Electricity was discovered by scientists in the 18th century, and it revolutionized the world. Many devices were invented to use this important energy. The smartphone was invented in the 21st century and has become very convenient for everyone. Today, wireless technology is used in many applications. Artificial intelligence and robots were created to help people work faster and better. These inventions have improved our daily lives in many ways. Technology continues to change and develop every day.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'When was electricity discovered?',
                    'options' => [
                        0 => 'In the 18th century',
                        1 => 'In the 19th century',
                        2 => 'In the 20th century',
                        3 => 'In the 21st century',
                    ],
                    'answer' => 'In the 18th century',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Electricity was discovered by scientists in the 18th century\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What has become very convenient for everyone?',
                    'options' => [
                        0 => 'Electricity',
                        1 => 'The smartphone',
                        2 => 'Wireless technology',
                        3 => 'Robots',
                    ],
                    'answer' => 'The smartphone',
                    'explanation_vi' => 'Đoạn văn viết \'The smartphone was invented in the 21st century and has become very convenient for everyone\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What were created to help people work faster and better?',
                    'options' => [
                        0 => 'Electricity and devices',
                        1 => 'Wireless applications',
                        2 => 'Artificial intelligence and robots',
                        3 => 'Digital inventions',
                    ],
                    'answer' => 'Artificial intelligence and robots',
                    'explanation_vi' => 'Đoạn văn nói \'Artificial intelligence and robots were created to help people work faster and better\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Wireless technology is used in many applications today.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Today, wireless technology is used in many applications\'.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Many ___ were invented to use electricity.',
                    'options' => null,
                    'answer' => 'devices',
                    'explanation_vi' => 'Đoạn văn nói \'Many devices were invented to use this important energy\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'A Talk About Great Inventions',
            'title_vi' => 'Cuộc trò chuyện về những phát minh vĩ đại',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc trò chuyện. Bạn sẽ nghe nó hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! I am reading about great inventions. Did you know that electricity was discovered by scientists in the 1700s?
Minh: Yes! And the smartphone was invented much later. It is a very convenient device.
Linh: That\'s true. The smartphone was improved many times. Now it has artificial intelligence applications.
Minh: Amazing! Wireless technology revolutionized how we communicate. Do you think robots will change our future?
Linh: Absolutely! Robots are digital inventions. They will help us in many ways.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'When was electricity discovered?',
                    'options' => [
                        0 => 'In the 1800s',
                        1 => 'In the 1700s',
                        2 => 'In the 1900s',
                    ],
                    'answer' => 'In the 1700s',
                    'explanation_vi' => 'Linh nói rằng điện được khám phá bởi các nhà khoa học vào những năm 1700.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is the smartphone described as?',
                    'options' => [
                        0 => 'A wireless device',
                        1 => 'A convenient device',
                        2 => 'A digital robot',
                    ],
                    'answer' => 'A convenient device',
                    'explanation_vi' => 'Minh nói rằng điện thoại thông minh là một thiết bị tiện lợi.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What revolutionized how we communicate?',
                    'options' => [
                        0 => 'Electricity',
                        1 => 'Artificial intelligence',
                        2 => 'Wireless technology',
                    ],
                    'answer' => 'Wireless technology',
                    'explanation_vi' => 'Minh nói rằng công nghệ không dây đã cách mạng hóa cách chúng ta giao tiếp.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The smartphone was ___ many times.',
                    'options' => null,
                    'answer' => 'improved',
                    'explanation_vi' => 'Linh nói rằng điện thoại thông minh đã được cải tiến nhiều lần.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Writing about an Invention',
            'title_vi' => 'Viết về một phát minh',
            'instructions_en' => 'Write a short paragraph (50-80 words) about an invention or technology you know. Use the passive voice with \'was/were + past participle\' to describe how it was invented or discovered. You can write about a real invention or imagine a new one.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) về một phát minh hoặc công nghệ mà bạn biết. Sử dụng câu bị động với \'was/were + past participle\' để mô tả cách nó được phát minh hoặc khám phá. Bạn có thể viết về một phát minh thực tế hoặc tưởng tượng một phát minh mới.',
            'passage' => null,
            'prompt_en' => 'Write about an invention or technology. Include:
- The name of the invention and what it is (device, application, etc.)
- How it was invented or discovered (use passive voice: was/were + past participle)
- Why it is convenient or how it revolutionized our lives',
            'prompt_vi' => 'Viết về một phát minh hoặc công nghệ. Bao gồm:
- Tên của phát minh và nó là gì (thiết bị, ứng dụng, v.v.)
- Cách nó được phát minh hoặc khám phá (sử dụng câu bị động: was/were + past participle)
- Tại sao nó tiện lợi hoặc cách nó cách mạng hóa cuộc sống của chúng ta',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '8-12' => [
        'reading' => [
            'title_en' => 'Life on Other Planets',
            'title_vi' => 'Sự sống trên hành tinh khác',
            'instructions_en' => 'Read the passage about life on other planets. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về sự sống trên hành tinh khác. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Scientists think there might be life on other planets in our solar system. The universe is very big and mysterious. Astronauts could discover new life forms in space one day. Some planets might have oxygen and water, but we are not sure. Mars is a red planet. It might have a thin atmosphere, but it is very cold. Aliens could exist on planets far away from Earth. We may find them when we explore more with our spacecraft. It is possible that life exists on other planets, but we need to discover more about them.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What might astronauts discover in space?',
                    'options' => [
                        0 => 'new life forms',
                        1 => 'new mountains',
                        2 => 'new oceans',
                        3 => 'new cities',
                    ],
                    'answer' => 'new life forms',
                    'explanation_vi' => 'Đoạn văn nói \'Astronauts could discover new life forms in space one day.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which planet is described as red in the passage?',
                    'options' => [
                        0 => 'Venus',
                        1 => 'Jupiter',
                        2 => 'Mars',
                        3 => 'Saturn',
                    ],
                    'answer' => 'Mars',
                    'explanation_vi' => 'Đoạn văn nói \'Mars is a red planet.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What might some planets have according to the passage?',
                    'options' => [
                        0 => 'oxygen and water',
                        1 => 'oxygen and fire',
                        2 => 'water and ice',
                        3 => 'fire and gravity',
                    ],
                    'answer' => 'oxygen and water',
                    'explanation_vi' => 'Đoạn văn nói \'Some planets might have oxygen and water, but we are not sure.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Mars has a thick atmosphere.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói Mars \'might have a thin atmosphere\', không phải thick atmosphere.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The ___ is very big and mysterious.',
                    'options' => null,
                    'answer' => 'universe',
                    'explanation_vi' => 'Đoạn văn nói \'The universe is very big and mysterious.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Life on Other Planets',
            'title_vi' => 'Sự sống trên hành tinh khác',
            'instructions_en' => 'Listen to the conversation about space and planets. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về không gian và hành tinh. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Do you think aliens might exist in the universe?
Mark: Yes, I think they could exist on other planets. The universe is very big.
Linh: What about oxygen? Aliens might not need oxygen like we do.
Mark: That\'s true. They may have a different atmosphere. Maybe we will discover new life forms one day.
Linh: I hope so! Astronauts could explore more planets in the solar system soon.
Mark: Yes, their spacecraft might find something mysterious and amazing!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Mark think about aliens?',
                    'options' => [
                        0 => 'Aliens definitely exist on other planets',
                        1 => 'Aliens could exist on other planets',
                        2 => 'Aliens do not exist anywhere',
                    ],
                    'answer' => 'Aliens could exist on other planets',
                    'explanation_vi' => 'Mark nói \'they could exist on other planets\' - anh ấy không chắc chắn nhưng nghĩ rằng có thể.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh say about oxygen?',
                    'options' => [
                        0 => 'All aliens need oxygen like humans',
                        1 => 'Aliens might not need oxygen like we do',
                        2 => 'Oxygen exists on all planets',
                    ],
                    'answer' => 'Aliens might not need oxygen like we do',
                    'explanation_vi' => 'Linh nói \'Aliens might not need oxygen like we do\' - cô ấy nói rằng người ngoài hành tinh có thể không cần oxy như con người.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What might astronauts do soon?',
                    'options' => [
                        0 => 'They might stay on Earth forever',
                        1 => 'They could explore more planets in the solar system',
                        2 => 'They might discover aliens on the Moon',
                    ],
                    'answer' => 'They could explore more planets in the solar system',
                    'explanation_vi' => 'Linh nói \'Astronauts could explore more planets in the solar system soon\' - phi hành gia có thể thám hiểm thêm nhiều hành tinh trong hệ mặt trời.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Mark\'s spacecraft might find something ___ and amazing!',
                    'options' => null,
                    'answer' => 'mysterious',
                    'explanation_vi' => '\'Mysterious\' có nghĩa là bí ẩn. Mark nói rằng tàu vũ trụ có thể tìm thấy điều gì đó bí ẩn và tuyệt vời.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Life on Other Planets',
            'title_vi' => 'Sự sống trên hành tinh khác',
            'instructions_en' => 'Write a short paragraph about what life on another planet might be like. Use the modals \'might\', \'could\', or \'may\' with infinitive verbs to express possibilities and speculation. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn về cuộc sống trên một hành tinh khác có thể như thế nào. Sử dụng các động từ khiếm khuyết \'might\', \'could\', hoặc \'may\' kèm theo động từ nguyên mẫu để diễn tả khả năng và suy đoán. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Imagine you are an astronaut exploring a mysterious planet in the solar system. Write about what you think life on this planet might be like. Include:
- What the atmosphere and gravity might be like on this planet
- What alien life forms could exist there
- What you might discover or explore on this mysterious planet',
            'prompt_vi' => 'Hãy tưởng tượng bạn là một phi hành gia thám hiểm một hành tinh bí ẩn trong hệ mặt trời. Viết về cuộc sống trên hành tinh này có thể như thế nào. Bao gồm:
- Bầu khí quyển và trọng lực trên hành tinh này có thể như thế nào
- Những dạng sống ngoài hành tinh nào có thể tồn tại ở đó
- Bạn có thể khám phá hoặc thám hiểm điều gì trên hành tinh bí ẩn này',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-1' => [
        'reading' => [
            'title_en' => 'The Silk Village of Hoi An',
            'title_vi' => 'Làng Tơ Lụa Hội An',
            'instructions_en' => 'Read the passage about a local community in Vietnam. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về một cộng đồng địa phương ở Việt Nam. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Hoi An is a small town in central Vietnam. It is famous for its traditional silk craft. The local artisans in Hoi An preserve this ancient heritage by making handmade silk products. For many generations, families have passed down their skills and techniques to younger members. The artisans use natural materials and traditional methods to create unique silk items like scarves and clothing. Today, the community works hard to promote their craft to visitors from around the world. Young people learn the techniques from experienced artisans in the village. This helps keep the heritage alive and supports the local economy.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Hoi An famous for?',
                    'options' => [
                        0 => 'traditional silk craft',
                        1 => 'handmade pottery',
                        2 => 'wooden furniture',
                        3 => 'local food',
                    ],
                    'answer' => 'traditional silk craft',
                    'explanation_vi' => 'Đoạn văn nói rõ \'It is famous for its traditional silk craft.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How do artisans in Hoi An preserve their heritage?',
                    'options' => [
                        0 => 'by selling products online',
                        1 => 'by making handmade silk products and passing down skills',
                        2 => 'by building new factories',
                        3 => 'by teaching in schools',
                    ],
                    'answer' => 'by making handmade silk products and passing down skills',
                    'explanation_vi' => 'Đoạn văn nói \'The local artisans preserve this ancient heritage by making handmade silk products\' và \'families have passed down their skills.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What materials do the artisans use?',
                    'options' => [
                        0 => 'plastic and metal',
                        1 => 'cotton and wool',
                        2 => 'natural materials',
                        3 => 'imported fabrics',
                    ],
                    'answer' => 'natural materials',
                    'explanation_vi' => 'Đoạn văn nói \'The artisans use natural materials and traditional methods.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Young people in Hoi An learn silk-making techniques from experienced artisans.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'Young people learn the techniques from experienced artisans in the village.\'',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'For many ___, families have passed down their skills to younger members.',
                    'options' => null,
                    'answer' => 'generations',
                    'explanation_vi' => 'Từ \'generations\' phù hợp với ngữ cảnh về việc truyền lại kỹ năng qua nhiều thế hệ.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Thanh Ha Pottery Village',
            'title_vi' => 'Làng gốm Thanh Hà',
            'instructions_en' => 'Listen to the conversation about a local community and its traditional craft. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại về cộng đồng địa phương và nghề thủ công truyền thống. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! I heard Thanh Ha village is famous for pottery. Is that true?
Minh: Yes! Thanh Ha is a traditional craft village. Many artisans live and work here.
Linh: How long has this heritage existed?
Minh: For many generations. My grandfather was an artisan, and my father is too. Now I am learning the skill.
Linh: That\'s wonderful! What materials do you use?
Minh: We use local clay and traditional techniques. All our products are handmade and unique.
Linh: Do you promote your pottery in the community?
Minh: Yes, we pass down our knowledge to young people. We want to preserve this heritage.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Thanh Ha village famous for?',
                    'options' => [
                        0 => 'silk weaving',
                        1 => 'pottery',
                        2 => 'bamboo products',
                    ],
                    'answer' => 'pottery',
                    'explanation_vi' => 'Trong cuộc hội thoại, Linh hỏi về làng Thanh Hà nổi tiếng vì cái gì, và Minh trả lời \'Thanh Ha is famous for pottery\' (Thanh Hà nổi tiếng vì gốm).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How long has the pottery heritage existed in Thanh Ha?',
                    'options' => [
                        0 => 'for ten years',
                        1 => 'for many generations',
                        2 => 'for five years',
                    ],
                    'answer' => 'for many generations',
                    'explanation_vi' => 'Minh nói \'For many generations\' (Trong nhiều thế hệ). Anh ấy kể rằng ông ngoại, cha, và bây giờ anh ấy đều là thợ thủ công.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What do the artisans in Thanh Ha use to make pottery?',
                    'options' => [
                        0 => 'plastic and modern machines',
                        1 => 'local clay and traditional techniques',
                        2 => 'imported materials only',
                    ],
                    'answer' => 'local clay and traditional techniques',
                    'explanation_vi' => 'Minh nói \'We use local clay and traditional techniques\' (Chúng tôi sử dụng đất sét địa phương và kỹ thuật truyền thống).',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh wants to ___ down their knowledge to young people to preserve the heritage.',
                    'options' => null,
                    'answer' => 'pass',
                    'explanation_vi' => 'Minh nói \'we pass down our knowledge to young people\' (chúng tôi truyền lại kiến thức cho những người trẻ). \'Pass down\' có nghĩa là truyền lại từ thế hệ này sang thế hệ khác.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Write about a Local Traditional Craft in Your Community',
            'title_vi' => 'Viết về một nghề thủ công truyền thống trong cộng đồng địa phương của bạn',
            'instructions_en' => 'Write a short paragraph (50-80 words) about a traditional craft from your local community or a community in Vietnam. Use the present simple to describe facts and use \'be famous for\' to explain what makes this craft special. You can write about a real craft or imagine one.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) về một nghề thủ công truyền thống từ cộng đồng địa phương của bạn hoặc một cộng đồng ở Việt Nam. Sử dụng thì hiện tại đơn để mô tả sự thật và dùng \'be famous for\' để giải thích điều gì làm cho nghề thủ công này đặc biệt. Bạn có thể viết về một nghề thủ công thực tế ',
            'passage' => null,
            'prompt_en' => 'Write about a traditional craft in a Vietnamese village or community. Include:
- The name of the village/community and what craft it is famous for
- How artisans make the handmade products (materials, techniques, or skills they use)
- How the community preserves and passes down this heritage to new generations',
            'prompt_vi' => 'Viết về một nghề thủ công truyền thống ở một làng hoặc cộng đồng Việt Nam. Bao gồm:
- Tên của làng/cộng đồng và nó nổi tiếng vì cái gì
- Cách các thợ thủ công làm những sản phẩm làm bằng tay (vật liệu, kỹ thuật, hoặc kỹ năng họ sử dụng)
- Cách cộng đồng bảo tồn và truyền lại di sản này cho các thế hệ mới',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-2' => [
        'reading' => [
            'title_en' => 'City Life vs Rural Life',
            'title_vi' => 'Cuộc sống thành thị so với cuộc sống nông thôn',
            'instructions_en' => 'Read the passage about city life and rural life. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về cuộc sống thành thị và nông thôn. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Hanoi is a big and modern city with many advantages and disadvantages. Living in the city is more convenient than living in the countryside. There are more job opportunities and better education facilities in the city. Entertainment is more exciting, and shopping is easier. However, city life is noisier and more crowded than rural life. The traffic is heavier, and pollution is worse. Food and housing are more expensive in the city. Many people commute to work every day and feel more stress. In contrast, rural life is quieter and less crowded. The air is cleaner, and life is cheaper. But there are fewer job opportunities and less entertainment in the countryside. Both city and rural life have their own advantages and disadvantages.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the passage, what is an advantage of city life?',
                    'options' => [
                        0 => 'There is less pollution and noise',
                        1 => 'There are more job opportunities and better education facilities',
                        2 => 'Food and housing are cheaper',
                        3 => 'There is less traffic',
                    ],
                    'answer' => 'There are more job opportunities and better education facilities',
                    'explanation_vi' => 'Đoạn văn nói rõ ràng rằng có nhiều cơ hội việc làm và tiện nghi giáo dục tốt hơn trong thành phố.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which of the following is a disadvantage of living in the city?',
                    'options' => [
                        0 => 'Life is quieter and cleaner',
                        1 => 'There are more entertainment options',
                        2 => 'City life is noisier and more crowded',
                        3 => 'Education facilities are better',
                    ],
                    'answer' => 'City life is noisier and more crowded',
                    'explanation_vi' => 'Đoạn văn nêu rõ rằng cuộc sống thành thị ồn ào hơn và đông đúc hơn cuộc sống nông thôn.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does the passage say about rural life?',
                    'options' => [
                        0 => 'It has more job opportunities than city life',
                        1 => 'It is noisier than city life',
                        2 => 'It is quieter and less crowded than city life',
                        3 => 'Food and housing are more expensive',
                    ],
                    'answer' => 'It is quieter and less crowded than city life',
                    'explanation_vi' => 'Đoạn văn nói rằng cuộc sống nông thôn yên tĩnh hơn và ít đông đúc hơn cuộc sống thành thị.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Living in the city is less convenient than living in the countryside.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói rõ rằng sống ở thành phố tiện lợi hơn sống ở nông thôn, không phải ít tiện lợi hơn.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Many people ___ to work every day and feel more stress.',
                    'options' => null,
                    'answer' => 'commute',
                    'explanation_vi' => 'Từ \'commute\' (đi lại hàng ngày) phù hợp với ngữ cảnh của câu về việc đi làm hàng ngày.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'City Life vs. Country Life',
            'title_vi' => 'Cuộc sống thành thị so với cuộc sống nông thôn',
            'instructions_en' => 'Listen to the conversation between Linh and Minh about city life and country life. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại giữa Linh và Minh về cuộc sống thành thị và nông thôn. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! Do you like living in Hà Nội?
Minh: Yes, but it\'s more crowded and noisier than my village. The traffic is terrible.
Linh: I agree. But the city has better education and more job opportunities.
Minh: That\'s true. However, living in the city is more expensive. And there is more pollution.
Linh: Yes, but the city has more entertainment and modern facilities. The disadvantage is the stress.
Minh: Exactly! The country is less crowded and more peaceful. It\'s the best place for me.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to Minh, what is worse in the city compared to his village?',
                    'options' => [
                        0 => 'The city has fewer job opportunities',
                        1 => 'The city is more crowded and noisier, and the traffic is terrible',
                        2 => 'The city has less entertainment',
                    ],
                    'answer' => 'The city is more crowded and noisier, and the traffic is terrible',
                    'explanation_vi' => 'Minh nói rằng thành phố đông đúc hơn, ồn ào hơn và giao thông tệ hơn so với làng của anh.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What are the advantages of living in the city according to Linh?',
                    'options' => [
                        0 => 'Better education, more job opportunities, and more entertainment',
                        1 => 'Less pollution and less traffic',
                        2 => 'Lower prices and less stress',
                    ],
                    'answer' => 'Better education, more job opportunities, and more entertainment',
                    'explanation_vi' => 'Linh nói rằng thành phố có giáo dục tốt hơn, nhiều cơ hội việc làm hơn, và nhiều giải trí hơn.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Minh prefer the country?',
                    'options' => [
                        0 => 'Because it has more modern facilities',
                        1 => 'Because it is less crowded, more peaceful, and the best place for him',
                        2 => 'Because it has more job opportunities',
                    ],
                    'answer' => 'Because it is less crowded, more peaceful, and the best place for him',
                    'explanation_vi' => 'Minh nói rằng nông thôn ít đông đúc hơn, yên bình hơn, và là nơi tốt nhất cho anh.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Living in the city is ___ expensive than living in the country.',
                    'options' => null,
                    'answer' => 'more',
                    'explanation_vi' => 'Để so sánh hai tính từ dài, chúng ta dùng \'more\' trước tính từ. \'More expensive\' = đắt đỏ hơn.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Comparing City Life and Rural Life',
            'title_vi' => 'So sánh cuộc sống thành thị và cuộc sống nông thôn',
            'instructions_en' => 'Write a short paragraph comparing city life and rural life. Use comparative and superlative adjectives to describe the differences. Include at least 3 advantages and 2 disadvantages of living in the city.',
            'instructions_vi' => 'Viết một đoạn văn ngắn so sánh cuộc sống thành thị và cuộc sống nông thôn. Sử dụng tính từ so sánh và tính từ so sánh nhất để mô tả sự khác biệt. Bao gồm ít nhất 3 lợi thế và 2 bất lợi của việc sống ở thành phố.',
            'passage' => null,
            'prompt_en' => 'Write about why some people prefer city life to rural life. Your paragraph should include:
- At least 2 comparative sentences about advantages (e.g., \'The city is more convenient than the countryside because...\')
- At least 1 sentence about disadvantages using comparatives (e.g., \'The city is more crowded and noisier than...\')
- Your personal opinion about whether the advantages or disadvantages are more important',
            'prompt_vi' => 'Viết về lý do tại sao một số người thích cuộc sống thành thị hơn cuộc sống nông thôn. Đoạn văn của bạn nên bao gồm:
- Ít nhất 2 câu so sánh về lợi thế (ví dụ: \'Thành phố tiện lợi hơn nông thôn vì...\')
- Ít nhất 1 câu về bất lợi sử dụng tính từ so sánh (ví dụ: \'Thành phố đông đúc hơn và ồn ào hơn...\')
- Ý kiến cá nhân của bạn về việc liệu lợi thế hay bất lợi quan trọng hơn',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-3' => [
        'reading' => [
            'title_en' => 'Healthy Habits for Teen Life',
            'title_vi' => 'Những Thói Quen Khoẻ Mạnh cho Tuổi Teen',
            'instructions_en' => 'Read the passage about healthy living for teenagers. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về sống khoẻ mạnh cho tuổi teen. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Teenagers should follow a balanced diet with plenty of protein, carbohydrates, vitamins, and minerals. You ought to avoid junk food because it is bad for your nutrition. Good habits include regular exercise and physical activity every day. Sleep deprivation and insomnia can harm your mental health and cause stress and anxiety. You should get 8 hours of sleep each night. Hydration is also important – drink enough water every day. Try meditation to reduce stress. These healthy habits will help you feel better and do better at school.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What should teenagers include in a balanced diet?',
                    'options' => [
                        0 => 'Protein, carbohydrates, vitamins, and minerals',
                        1 => 'Only junk food and sugar',
                        2 => 'Only protein and carbohydrates',
                        3 => 'Only vitamins and water',
                    ],
                    'answer' => 'Protein, carbohydrates, vitamins, and minerals',
                    'explanation_vi' => 'Đoạn văn nói rõ một chế độ ăn cân bằng nên có protein, carbohydrates, vitamins, và minerals.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How many hours of sleep should teenagers get each night?',
                    'options' => [
                        0 => '5 hours',
                        1 => '6 hours',
                        2 => '8 hours',
                        3 => '10 hours',
                    ],
                    'answer' => '8 hours',
                    'explanation_vi' => 'Đoạn văn nói rõ \'You should get 8 hours of sleep each night\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What can meditation help reduce?',
                    'options' => [
                        0 => 'Protein intake',
                        1 => 'Stress',
                        2 => 'Sleep hours',
                        3 => 'Physical activity',
                    ],
                    'answer' => 'Stress',
                    'explanation_vi' => 'Đoạn văn nói \'Try meditation to reduce stress\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Sleep deprivation can harm your mental health.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Sleep deprivation and insomnia can harm your mental health\'.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'You ought to avoid ___ because it is bad for your nutrition.',
                    'options' => null,
                    'answer' => 'junk food',
                    'explanation_vi' => 'Câu trong đoạn văn nói \'You ought to avoid junk food because it is bad for your nutrition\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Healthy Living for Teens',
            'title_vi' => 'Sống khoẻ tuổi teen',
            'instructions_en' => 'Listen to the conversation between two friends talking about healthy habits. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc trò chuyện giữa hai bạn nói về thói quen sống khoẻ. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! You look tired today. What\'s wrong?
Minh: I have insomnia. I don\'t sleep well at night.
Linh: That\'s bad. Sleep deprivation is not good for your mental health. You should go to bed earlier.
Minh: You\'re right. I also eat too much junk food. I feel stressed.
Linh: You ought to eat a balanced diet with protein, carbohydrates, vitamins and minerals. And you should exercise every day.
Minh: Good idea! I will start meditation too. What about hydration?
Linh: You should drink more water. These habits will help you feel better!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Minh\'s main problem?',
                    'options' => [
                        0 => 'He eats too much protein',
                        1 => 'He has insomnia and doesn\'t sleep well',
                        2 => 'He doesn\'t drink enough water',
                    ],
                    'answer' => 'He has insomnia and doesn\'t sleep well',
                    'explanation_vi' => 'Minh nói \'I have insomnia. I don\'t sleep well at night.\' - đây là vấn đề chính của anh ấy.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh say about sleep deprivation?',
                    'options' => [
                        0 => 'It is good for your body',
                        1 => 'It is not good for your mental health',
                        2 => 'It helps you exercise better',
                    ],
                    'answer' => 'It is not good for your mental health',
                    'explanation_vi' => 'Linh nói \'Sleep deprivation is not good for your mental health.\' - thiếu ngủ không tốt cho sức khoẻ tâm thần.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does Linh recommend Minh should eat?',
                    'options' => [
                        0 => 'Only junk food',
                        1 => 'A balanced diet with protein, carbohydrates, vitamins and minerals',
                        2 => 'Only vegetables',
                    ],
                    'answer' => 'A balanced diet with protein, carbohydrates, vitamins and minerals',
                    'explanation_vi' => 'Linh nói \'You ought to eat a balanced diet with protein, carbohydrates, vitamins and minerals.\' - chế độ ăn cân bằng với các chất dinh dưỡng.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh says: \'You should ___ more water.\'',
                    'options' => null,
                    'answer' => 'drink',
                    'explanation_vi' => 'Linh nói về hydration (cấp nước) và khuyến nghị Minh nên uống nhiều nước hơn. \'You should drink more water.\'',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Health Advice for a Friend',
            'title_vi' => 'Lời khuyên về sức khỏe cho bạn',
            'instructions_en' => 'Write a short message to a Vietnamese friend giving health advice. Use \'should\' or \'ought to\' to make recommendations about their daily habits. Include at least 3 different health topics from the unit vocabulary.',
            'instructions_vi' => 'Viết một tin nhắn ngắn cho bạn người Việt và đưa ra lời khuyên về sức khỏe. Sử dụng \'should\' hoặc \'ought to\' để đưa ra các gợi ý về thói quen hàng ngày. Bao gồm ít nhất 3 chủ đề sức khỏe khác nhau từ từ vựng của bài học.',
            'passage' => null,
            'prompt_en' => 'Your friend Minh is very busy with school and doesn\'t take care of his/her health well. Write a message giving Minh advice about healthy living. Include:
- At least two recommendations about nutrition (balanced diet, protein, vitamins, or avoiding junk food)
- At least one recommendation about sleep or mental health (sleep deprivation, stress, anxiety, or meditation)
- At least one recommendation about exercise or physical activity',
            'prompt_vi' => 'Bạn của bạn là Minh rất bận rộn với học tập và không chăm sóc sức khỏe tốt. Viết một tin nhắn đưa ra lời khuyên cho Minh về sống khoẻ. Bao gồm:
- Ít nhất hai gợi ý về dinh dưỡng (chế độ ăn cân bằng, protein, vitamin, hoặc tránh đồ ăn vặt không tốt)
- Ít nhất một gợi ý về ngủ hoặc sức khỏe tâm thần (thiếu ngủ, căng thẳng, lo âu, hoặc thiền)
- Ít nhất một gợi ý về tập thể dục hoặc hoạt động thể chất',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-4' => [
        'reading' => [
            'title_en' => 'My Grandmother\'s Stories',
            'title_vi' => 'Những câu chuyện của bà tôi',
            'instructions_en' => 'Read the passage about a student\'s grandmother and her memories. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về bà của một học sinh và những ký ức của bà. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'My grandmother often tells me about her childhood in Hà Nội. Back then, she used to walk to school every day, and she would play with her friends in the park after classes. Those were unforgettable memories for her. She says that life was different from nowadays. Her generation did not have computers or smartphones. They would spend time together more than young people do today. Nowadays, I compare my life with hers, and I see many changes. However, some traditions are similar. We still celebrate Tết together as a family, just like she did. My grandmother feels nostalgic when she remembers those old days.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What did the grandmother use to do every day back then?',
                    'options' => [
                        0 => 'She used to walk to school every day',
                        1 => 'She used to ride a bicycle to school',
                        2 => 'She used to take the bus to school',
                        3 => 'She used to stay at home',
                    ],
                    'answer' => 'She used to walk to school every day',
                    'explanation_vi' => 'Bài văn nói rõ \'she used to walk to school every day\' (bà thường đi bộ đến trường mỗi ngày).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How is the grandmother\'s childhood different from life nowadays?',
                    'options' => [
                        0 => 'Her generation had computers and smartphones',
                        1 => 'Her generation did not have computers or smartphones',
                        2 => 'Her generation spent less time together',
                        3 => 'Her generation had more technology',
                    ],
                    'answer' => 'Her generation did not have computers or smartphones',
                    'explanation_vi' => 'Bài văn nói \'Her generation did not have computers or smartphones\' (thế hệ của bà không có máy tính hay điện thoại thông minh).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What tradition is still similar between the grandmother and the student?',
                    'options' => [
                        0 => 'Playing in the park',
                        1 => 'Walking to school',
                        2 => 'Celebrating Tết together as a family',
                        3 => 'Using smartphones',
                    ],
                    'answer' => 'Celebrating Tết together as a family',
                    'explanation_vi' => 'Bài văn nói \'We still celebrate Tết together as a family, just like she did\' (chúng tôi vẫn tổ chức Tết cùng gia đình, giống như bà đã làm).',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'The grandmother feels happy and nostalgic when she remembers her old days.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Bài văn kết thúc bằng \'My grandmother feels nostalgic when she remembers those old days\' (bà cảm thấy hoài niệm khi nhớ lại những ngày xưa).',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Back then, the grandmother would ___ with her friends in the park after classes.',
                    'options' => null,
                    'answer' => 'play',
                    'explanation_vi' => 'Bài văn nói \'she would play with her friends in the park after classes\' (bà thường chơi với bạn bè ở công viên sau giờ học).',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Remembering Childhood',
            'title_vi' => 'Nhớ về Thời Thơ Ấu',
            'instructions_en' => 'Listen to the conversation between Linh and her grandmother. Answer the questions about what you hear.',
            'instructions_vi' => 'Nghe cuộc trò chuyện giữa Linh và bà của cô ấy. Trả lời các câu hỏi về những gì bạn nghe được.',
            'passage' => 'Linh: Bà ơi, bà có nhớ về thời thơ ấu của bà không?
Grandmother: Vâng, con. Tôi có rất nhiều ký ức đẹp. Hồi đó, tôi thường chơi với các bạn ở công viên mỗi ngày.
Linh: Bà thường chơi những trò chơi gì?
Grandmother: Tôi sẽ chơi nhảy dây và đá cầu. Những ký ức đó thật không thể quên được.
Linh: Ngày nay khác hơn nhiều. Bây giờ trẻ em thường chơi trò chơi điện tử.
Grandmother: Đúng vậy. Thế hệ của tôi và thế hệ của con rất khác nhau. Nhưng cả hai thế hệ đều có những truyền thống đẹp.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What did Linh\'s grandmother use to do in her childhood?',
                    'options' => [
                        0 => 'She used to play video games in the park',
                        1 => 'She used to play jump rope and shuttlecock every day',
                        2 => 'She used to stay at home and read books',
                    ],
                    'answer' => 'She used to play jump rope and shuttlecock every day',
                    'explanation_vi' => 'Bà ngoại nói: \'Hồi đó, tôi thường chơi với các bạn ở công viên mỗi ngày\' và \'Tôi sẽ chơi nhảy dây và đá cầu.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the grandmother, what do children play nowadays?',
                    'options' => [
                        0 => 'They play in the park like before',
                        1 => 'They play video games',
                        2 => 'They play traditional games with friends',
                    ],
                    'answer' => 'They play video games',
                    'explanation_vi' => 'Linh nói: \'Ngày nay khác hơn nhiều. Bây giờ trẻ em thường chơi trò chơi điện tử.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How does the grandmother describe her childhood memories?',
                    'options' => [
                        0 => 'Sad and forgotten',
                        1 => 'Unforgettable and beautiful',
                        2 => 'Similar to nowadays',
                    ],
                    'answer' => 'Unforgettable and beautiful',
                    'explanation_vi' => 'Bà ngoại nói: \'Tôi có rất nhiều ký ức đẹp\' và \'Những ký ức đó thật không thể quên được.\'',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The grandmother\'s generation and Linh\'s generation are very ___ to each other.',
                    'options' => null,
                    'answer' => 'different',
                    'explanation_vi' => 'Bà ngoại nói: \'Thế hệ của tôi và thế hệ của con rất khác nhau.\' (different = khác nhau)',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Childhood Memories',
            'title_vi' => 'Những ký ức tuổi thơ của tôi',
            'instructions_en' => 'Write about your childhood memories and compare them with life nowadays. Use \'used to\' or \'would\' to describe past habits, and use comparison structures to show similarities and differences.',
            'instructions_vi' => 'Viết về những ký ức tuổi thơ của bạn và so sánh chúng với cuộc sống ngày nay. Sử dụng \'used to\' hoặc \'would\' để mô tả những thói quen trong quá khứ, và sử dụng các cấu trúc so sánh để chỉ ra những điểm giống và khác nhau.',
            'passage' => null,
            'prompt_en' => 'Write 50-80 words about an unforgettable memory from your childhood. Include:
- One habit you used to do or would do back then (using \'used to\' or \'would\')
- A comparison between your childhood and nowadays (using \'as...as\', \'more/less than\', or \'similar/different\')
- Why this memory is nostalgic or important to you',
            'prompt_vi' => 'Viết 50-80 từ về một ký ức không thể quên được từ tuổi thơ của bạn. Bao gồm:
- Một thói quen bạn thường xuyên làm hoặc sẽ làm hồi đó (sử dụng \'used to\' hoặc \'would\')
- Một so sánh giữa tuổi thơ của bạn và ngày nay (sử dụng \'as...as\', \'more/less than\', hoặc \'similar/different\')
- Lý do tại sao ký ức này là hoài niệm hoặc quan trọng đối với bạn',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-5' => [
        'reading' => [
            'title_en' => 'Linh\'s Unforgettable Journey',
            'title_vi' => 'Chuyến đi không thể quên của Linh',
            'instructions_en' => 'Read the passage about Linh\'s experience. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về trải nghiệm của Linh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Last summer, Linh had an unforgettable adventure in Hạ Long Bay. Before she went there, she had never seen such a beautiful place. During her journey, she encountered many challenges. The boat had broken down before they reached the island, but Linh overcame her fear and helped the captain. Her achievement made a strong impression on everyone. The trip turned out to be thrilling and memorable. Now when Linh looks back on that experience, she does not regret anything. She reflects on how brave she was, and she feels proud of herself.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where did Linh go on her adventure?',
                    'options' => [
                        0 => 'Hạ Long Bay',
                        1 => 'Phú Quốc Island',
                        2 => 'Da Nang',
                        3 => 'Nha Trang',
                    ],
                    'answer' => 'Hạ Long Bay',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Linh had an unforgettable adventure in Hạ Long Bay\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What had happened before Linh reached the island?',
                    'options' => [
                        0 => 'The weather became bad',
                        1 => 'The boat had broken down',
                        2 => 'Linh got sick',
                        3 => 'They lost their way',
                    ],
                    'answer' => 'The boat had broken down',
                    'explanation_vi' => 'Đoạn văn nói \'The boat had broken down before they reached the island\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How did Linh feel about her journey now?',
                    'options' => [
                        0 => 'She regrets going there',
                        1 => 'She does not regret anything',
                        2 => 'She felt embarrassed',
                        3 => 'She was disappointed',
                    ],
                    'answer' => 'She does not regret anything',
                    'explanation_vi' => 'Đoạn văn nói \'Now when Linh looks back on that experience, she does not regret anything\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Linh had seen Hạ Long Bay many times before her journey last summer.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'Before she went there, she had never seen such a beautiful place\', nên cô ấy chưa bao giờ đến đó trước đó.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh\'s brave action during the boat problem made a strong ___ on everyone.',
                    'options' => null,
                    'answer' => 'impression',
                    'explanation_vi' => 'Đoạn văn nói \'Her achievement made a strong impression on everyone\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Linh\'s Unforgettable Journey',
            'title_vi' => 'Chuyến đi không thể quên của Linh',
            'instructions_en' => 'Listen to the conversation between Linh and her friend Minh. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại giữa Linh và bạn của cô ấy là Minh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh: Hi Linh! How was your trip to Sapa last month?
Linh: It was amazing! Before I went there, I had never encountered mountains so beautiful. The journey was unforgettable.
Minh: That sounds thrilling! Did you face any challenges?
Linh: Yes, I had climbed for three hours before I felt very tired. But I overcame that challenge and reached the top!
Minh: Wow! What an achievement! Did anything embarrassing happen?
Linh: Actually, I fell down once, but it turned out to be funny, not embarrassing. I will never regret that experience!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What had Linh never done before she went to Sapa?',
                    'options' => [
                        0 => 'She had never encountered mountains so beautiful',
                        1 => 'She had never climbed a mountain',
                        2 => 'She had never traveled to Vietnam',
                    ],
                    'answer' => 'She had never encountered mountains so beautiful',
                    'explanation_vi' => 'Linh nói: \'Before I went there, I had never encountered mountains so beautiful.\' Điều này cho thấy trước khi đi Sapa, cô ấy chưa bao giờ gặp những ngọn núi đẹp như vậy.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What did Linh do before she felt very tired?',
                    'options' => [
                        0 => 'She had walked for three hours',
                        1 => 'She had climbed for three hours',
                        2 => 'She had rested for three hours',
                    ],
                    'answer' => 'She had climbed for three hours',
                    'explanation_vi' => 'Linh nói: \'I had climbed for three hours before I felt very tired.\' Cô ấy đã leo núi trong ba giờ trước khi cảm thấy mệt.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'How did Linh feel about falling down during the trip?',
                    'options' => [
                        0 => 'She felt very embarrassed',
                        1 => 'She regretted the experience',
                        2 => 'She thought it was funny, not embarrassing',
                    ],
                    'answer' => 'She thought it was funny, not embarrassing',
                    'explanation_vi' => 'Linh nói: \'I fell down once, but it turned out to be funny, not embarrassing.\' Cô ấy cảm thấy nó hài hước chứ không xấu hổ.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh says she will never ___ that experience.',
                    'options' => null,
                    'answer' => 'regret',
                    'explanation_vi' => 'Linh nói: \'I will never regret that experience!\' Từ \'regret\' (hối tiếc) phù hợp với ngữ cảnh - cô ấy sẽ không bao giờ tiếc nuối về trải nghiệm đó.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Writing about a Memorable Experience',
            'title_vi' => 'Viết về một trải nghiệm đáng nhớ',
            'instructions_en' => 'Write a short paragraph (50-80 words) about a memorable experience from your past. Use the past perfect tense (had + past participle) to show what happened before the main event. Focus on the sequence of events.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) về một trải nghiệm đáng nhớ trong quá khứ của bạn. Sử dụng thì quá khứ hoàn thành (had + past participle) để cho thấy điều gì xảy ra trước sự kiện chính. Tập trung vào trình tự các sự kiện.',
            'passage' => null,
            'prompt_en' => 'Think about an unforgettable experience or adventure you have had. Write about it and include:
- What had happened before the main event (use past perfect)
- A challenge you had to overcome
- How this experience turned out and what impression it made on you',
            'prompt_vi' => 'Hãy nghĩ về một trải nghiệm hoặc cuộc phiêu lưu không thể quên của bạn. Viết về nó và bao gồm:
- Điều gì đã xảy ra trước sự kiện chính (sử dụng quá khứ hoàn thành)
- Một thử thách mà bạn phải vượt qua
- Trải nghiệm này kết quả như thế nào và nó để lại ấn tượng gì cho bạn',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-6' => [
        'reading' => [
            'title_en' => 'Vietnamese Lifestyle: Then and Now',
            'title_vi' => 'Lối sống Việt xưa và nay',
            'instructions_en' => 'Read the passage about how Vietnamese lifestyle has changed. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về cách lối sống Việt Nam đã thay đổi. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'In the past, Vietnamese people used to live a traditional lifestyle. Rural communities used to work in agriculture and spend time with family. Compared to nowadays, life was slower and simpler. People valued community customs and family traditions very much.

Nowadays, Vietnamese lifestyle has changed a lot. Modern technology brings convenience to urban and rural areas. Whereas people in the past used to work in fields all day, today many people work in offices or use computers. However, Vietnamese families still value community and family customs, similar to the traditional lifestyle. Life is different, but family remains important.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What did rural communities used to do in the past?',
                    'options' => [
                        0 => 'They used to work in offices',
                        1 => 'They used to work in agriculture',
                        2 => 'They used to use computers',
                        3 => 'They used to live in cities',
                    ],
                    'answer' => 'They used to work in agriculture',
                    'explanation_vi' => 'Đoạn văn nói \'Rural communities used to work in agriculture\' (Cộng đồng nông thôn xưa kia làm việc trong nông nghiệp).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Compared to nowadays, how was life in the past?',
                    'options' => [
                        0 => 'Faster and more complicated',
                        1 => 'Slower and simpler',
                        2 => 'More modern and convenient',
                        3 => 'More technology-based',
                    ],
                    'answer' => 'Slower and simpler',
                    'explanation_vi' => 'Đoạn văn nói \'Compared to nowadays, life was slower and simpler\' (So với ngày nay, cuộc sống xưa kia chậm hơn và đơn giản hơn).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does modern technology bring to Vietnamese areas?',
                    'options' => [
                        0 => 'Agriculture and farming',
                        1 => 'Traditional customs',
                        2 => 'Convenience',
                        3 => 'Family values',
                    ],
                    'answer' => 'Convenience',
                    'explanation_vi' => 'Đoạn văn nói \'Modern technology brings convenience to urban and rural areas\' (Công nghệ hiện đại mang sự tiện lợi đến các khu vực thành thị và nông thôn).',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Vietnamese families nowadays do not value community and family customs anymore.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'Vietnamese families still value community and family customs\' (Gia đình Việt Nam vẫn coi trọng cộng đồng và phong tục gia đình).',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Whereas people in the past used to work in fields all day, today many people work in ___ or use computers.',
                    'options' => null,
                    'answer' => 'offices',
                    'explanation_vi' => 'Đoạn văn nói \'today many people work in offices or use computers\' (ngày nay nhiều người làm việc trong văn phòng hoặc sử dụng máy tính).',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Vietnamese Lifestyle: Then and Now',
            'title_vi' => 'Lối sống Việt xưa và nay',
            'instructions_en' => 'Listen to the conversation between Linh and her grandmother. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc trò chuyện giữa Linh và bà của cô ấy. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Bà ơi, lối sống xưa và nay có khác nhau không?
Grandmother: Có chứ, con yêu. In the past, we used to work in agriculture every day. Nowadays, many people work in the city with modern technology.
Linh: Compared to the past, is life better now?
Grandmother: Yes, we have more convenience. Whereas in the past we valued community and customs very much, nowadays young people focus on their own life.
Linh: So the values are different?
Grandmother: Yes, but family is still similar and important.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What did people used to do in the past?',
                    'options' => [
                        0 => 'They used to work with modern technology',
                        1 => 'They used to work in agriculture',
                        2 => 'They used to live in the city',
                    ],
                    'answer' => 'They used to work in agriculture',
                    'explanation_vi' => 'Bà ngoại nói: \'In the past, we used to work in agriculture every day.\' (Xưa kia, chúng tôi thường làm nông nghiệp mỗi ngày.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the grandmother, what is different between past and present values?',
                    'options' => [
                        0 => 'In the past, people valued community and customs; nowadays, young people focus on their own life',
                        1 => 'In the past, people had more convenience',
                        2 => 'In the past, people used modern technology',
                    ],
                    'answer' => 'In the past, people valued community and customs; nowadays, young people focus on their own life',
                    'explanation_vi' => 'Bà ngoại nói: \'Whereas in the past we valued community and customs very much, nowadays young people focus on their own life.\' (Trong khi xưa chúng tôi rất coi trọng cộng đồng và phong tục, thì ngày nay những người trẻ tập trung vào cuộc sống của riêng họ.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does the grandmother say about family?',
                    'options' => [
                        0 => 'Family is not important nowadays',
                        1 => 'Family is still similar and important',
                        2 => 'Family has changed completely',
                    ],
                    'answer' => 'Family is still similar and important',
                    'explanation_vi' => 'Bà ngoại nói: \'Yes, but family is still similar and important.\' (Nhưng gia đình vẫn tương tự và quan trọng.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Compared to the past, life has more ___ nowadays.',
                    'options' => null,
                    'answer' => 'convenience',
                    'explanation_vi' => 'Bà ngoại nói: \'Yes, we have more convenience.\' (Vâng, chúng ta có nhiều sự tiện lợi hơn.) Từ \'convenience\' (sự tiện lợi) hoàn thành câu.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Comparing Vietnamese Lifestyles: Then and Now',
            'title_vi' => 'So sánh Lối Sống Việt Nam: Xưa và Nay',
            'instructions_en' => 'Write a short paragraph comparing how Vietnamese people\'s lifestyle has changed. Use the comparative structures from this unit (used to + V, whereas, compared to) to contrast the past and present. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn so sánh cách lối sống của người Việt Nam đã thay đổi như thế nào. Sử dụng các cấu trúc so sánh từ bài học (used to + V, whereas, compared to) để đối chiếu quá khứ và hiện tại. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about how Vietnamese lifestyle has changed from the past to now. Include:
- One thing people used to do in the past (use \'used to + V\')
- How that is different now (use \'whereas\' or \'compared to\')
- One value or custom that is similar in both times',
            'prompt_vi' => 'Viết về cách lối sống của người Việt Nam đã thay đổi từ quá khứ đến nay. Bao gồm:
- Một điều mà mọi người từng làm trong quá khứ (dùng \'used to + V\')
- Cách khác biệt bây giờ (dùng \'whereas\' hoặc \'compared to\')
- Một giá trị hoặc phong tục tương tự ở cả hai thời kỳ',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-7' => [
        'reading' => [
            'title_en' => 'Natural Wonders of Vietnam',
            'title_vi' => 'Những Kỳ Quan Thiên Nhiên của Việt Nam',
            'instructions_en' => 'Read the passage about natural wonders in Vietnam. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về những kỳ quan thiên nhiên ở Việt Nam. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Vietnam is known as a country with many magnificent natural wonders. Ha Long Bay is considered one of the most breathtaking landscapes in the world. It is located in Quang Ninh province and is famous for its beautiful limestone caves and coral reefs. Visitors can enjoy hiking trails and visit the caves by boat. The bay is also an important tourist attraction that is visited by thousands of tourists every year.

Ban Gioc Waterfall is another natural wonder that is preserved by the government. This breathtaking waterfall is accessible to tourists and has good accommodation nearby. The landscape around the waterfall is magnificent, with green mountains and fresh air. Many endangered plants and animals live in this area. People should visit these natural wonders to understand the importance of protecting Vietnam\'s nature.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Ha Long Bay famous for?',
                    'options' => [
                        0 => 'Its beautiful limestone caves and coral reefs',
                        1 => 'Its volcano and canyon',
                        2 => 'Its hiking trails only',
                        3 => 'Its accommodation facilities',
                    ],
                    'answer' => 'Its beautiful limestone caves and coral reefs',
                    'explanation_vi' => 'Đoạn văn nói Ha Long Bay nổi tiếng vì những hang động đá vôi và rạn san hô đẹp.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Where is Ha Long Bay located?',
                    'options' => [
                        0 => 'Ho Chi Minh City',
                        1 => 'Quang Ninh province',
                        2 => 'Da Nang',
                        3 => 'Hue',
                    ],
                    'answer' => 'Quang Ninh province',
                    'explanation_vi' => 'Đoạn văn nói rõ Ha Long Bay nằm ở tỉnh Quảng Ninh.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What does the government do to Ban Gioc Waterfall?',
                    'options' => [
                        0 => 'It destroys it',
                        1 => 'It preserves it',
                        2 => 'It ignores it',
                        3 => 'It sells it',
                    ],
                    'answer' => 'It preserves it',
                    'explanation_vi' => 'Đoạn văn nói Ban Gioc Waterfall được chính phủ bảo vệ (preserved).',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Ban Gioc Waterfall is not accessible to tourists.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói Ban Gioc Waterfall dễ tiếp cận (accessible) với du khách.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Ha Long Bay is visited by thousands of ___ every year.',
                    'options' => null,
                    'answer' => 'tourists',
                    'explanation_vi' => 'Đoạn văn nói Ha Long Bay được thăm bởi hàng ngàn du khách mỗi năm.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Natural Wonders of Vietnam',
            'title_vi' => 'Kỳ quan thiên nhiên của Việt Nam',
            'instructions_en' => 'Listen to the conversation about natural wonders. You will hear it once. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại về kỳ quan thiên nhiên. Bạn sẽ nghe một lần. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! Have you visited any natural wonders in Vietnam?
Minh: Yes! I visited Phong Nha Cave last month. It is known as one of the most magnificent caves in Asia.
Linh: That sounds amazing! Is it easy to visit?
Minh: Yes, it is very accessible. There are hiking trails and good accommodation nearby. The landscape is breathtaking.
Linh: I want to visit it too! Are there other natural wonders there?
Minh: Yes! Ha Long Bay is also located in the north. It is famous for its beautiful coral reefs and limestone cliffs. Many tourists visit it every year.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Phong Nha known as?',
                    'options' => [
                        0 => 'One of the most magnificent caves in Asia',
                        1 => 'A dangerous volcano in Vietnam',
                        2 => 'A breathtaking waterfall in the south',
                    ],
                    'answer' => 'One of the most magnificent caves in Asia',
                    'explanation_vi' => 'Minh nói \'It is known as one of the most magnificent caves in Asia\' (Nó được biết đến là một trong những hang động tuyệt vời nhất ở châu Á).',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Is Phong Nha easy to visit?',
                    'options' => [
                        0 => 'No, it is very difficult to reach',
                        1 => 'Yes, it is very accessible',
                        2 => 'No, there is no accommodation',
                    ],
                    'answer' => 'Yes, it is very accessible',
                    'explanation_vi' => 'Minh trả lời \'Yes, it is very accessible. There are hiking trails and good accommodation nearby\' (Có, nó rất dễ tiếp cận. Có những đường mòn đi bộ và chỗ ở tốt gần đó).',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Ha Long Bay famous for?',
                    'options' => [
                        0 => 'Its dangerous volcanoes',
                        1 => 'Its beautiful coral reefs and limestone cliffs',
                        2 => 'Its large waterfalls',
                    ],
                    'answer' => 'Its beautiful coral reefs and limestone cliffs',
                    'explanation_vi' => 'Minh nói \'It is famous for its beautiful coral reefs and limestone cliffs\' (Nó nổi tiếng vì những rạn san hô đẹp và những vách đá vôi).',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'The landscape at Phong Nha is ___.',
                    'options' => null,
                    'answer' => 'breathtaking',
                    'explanation_vi' => 'Minh nói \'The landscape is breathtaking\' (Phong cảnh ngoạn mục). Đây là một tính từ mô tả cảnh quan tuyệt đẹp.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Describing a Natural Wonder',
            'title_vi' => 'Mô tả một Kỳ quan Thiên nhiên',
            'instructions_en' => 'Write a short description of a natural wonder. Use passive voice structures like \'is known as\', \'is located in\', \'is considered\'. You can choose a real natural wonder from Vietnam or the world, or imagine one. Write 50-80 words.',
            'instructions_vi' => 'Viết một mô tả ngắn về một kỳ quan thiên nhiên. Sử dụng cấu trúc câu bị động như \'is known as\', \'is located in\', \'is considered\'. Bạn có thể chọn một kỳ quan thiên nhiên thực tế ở Việt Nam hoặc trên thế giới, hoặc tưởng tượng ra một cái. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about a natural wonder. Include:
- The name and what it is known as (use \'is known as\')
- Where it is located (use \'is located in\')
- Why it is considered special or magnificent (use \'is considered\' and descriptive words like \'breathtaking\' or \'magnificent\')',
            'prompt_vi' => 'Viết về một kỳ quan thiên nhiên. Bao gồm:
- Tên gọi và nó được biết đến như thế nào (dùng \'is known as\')
- Nó nằm ở đâu (dùng \'is located in\')
- Tại sao nó được coi là đặc biệt hoặc hùng vĩ (dùng \'is considered\' và các từ miêu tả như \'breathtaking\' hoặc \'magnificent\')',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-8' => [
        'reading' => [
            'title_en' => 'Linh\'s Trip to Da Nang',
            'title_vi' => 'Chuyến du lịch của Linh tới Đà Nẵng',
            'instructions_en' => 'Read the passage about Linh\'s recent trip to Da Nang. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về chuyến du lịch gần đây của Linh tới Đà Nẵng. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Last month, Linh went to Da Nang with her family. They made a booking for a double room and a single room at a nice hotel near the beach. The check-in was easy, and the staff was very friendly. Their tour guide, Mr. Tuan, showed them the best attractions in the city. They visited the breathtaking Marble Mountains and the beautiful Han Market. Linh has never seen such memorable views before. On the last day, they did check-out in the morning and bought some souvenirs at the airport. The trip was within their budget, and Linh recommends Da Nang to all her friends.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What type of accommodation did Linh\'s family book?',
                    'options' => [
                        0 => 'One double room only',
                        1 => 'A double room and a single room',
                        2 => 'Two single rooms',
                        3 => 'A hotel far from the beach',
                    ],
                    'answer' => 'A double room and a single room',
                    'explanation_vi' => 'Đoạn văn nói \'They made a booking for a double room and a single room at a nice hotel near the beach.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Who was Linh\'s tour guide in Da Nang?',
                    'options' => [
                        0 => 'Linh\'s mother',
                        1 => 'A hotel staff member',
                        2 => 'Mr. Tuan',
                        3 => 'A souvenir seller',
                    ],
                    'answer' => 'Mr. Tuan',
                    'explanation_vi' => 'Đoạn văn nói \'Their tour guide, Mr. Tuan, showed them the best attractions in the city.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which attraction did Linh visit?',
                    'options' => [
                        0 => 'The Marble Mountains and Han Market',
                        1 => 'The airport market only',
                        2 => 'The beach hotel only',
                        3 => 'The city center shops',
                    ],
                    'answer' => 'The Marble Mountains and Han Market',
                    'explanation_vi' => 'Đoạn văn nói \'They visited the breathtaking Marble Mountains and the beautiful Han Market.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Linh has seen memorable views like Da Nang\'s views many times before.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'Linh has never seen such memorable views before.\' (chưa bao giờ thấy)',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh recommends Da Nang to all her ___.',
                    'options' => null,
                    'answer' => 'friends',
                    'explanation_vi' => 'Câu cuối cùng của đoạn văn nói \'Linh recommends Da Nang to all her friends.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'A Trip to Ha Long Bay',
            'title_vi' => 'Một chuyến du lịch tới Vịnh Hạ Long',
            'instructions_en' => 'Listen to the conversation about a trip to Ha Long Bay. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại về một chuyến du lịch tới Vịnh Hạ Long. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! I have just returned from Ha Long Bay. It was amazing!
Minh: Really? Tell me about your trip!
Linh: We stayed in a beautiful hotel. The accommodation was very comfortable. We had a double room with a sea view.
Minh: That sounds wonderful! What did you do there?
Linh: Our tour guide showed us many attractions. The limestone mountains were breathtaking! We also visited a floating village.
Minh: Did you buy any souvenirs?
Linh: Yes, I bought some local handicrafts. It was a memorable experience. I recommend Ha Long Bay to everyone!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What type of room did Linh have at the hotel?',
                    'options' => [
                        0 => 'A single room',
                        1 => 'A double room',
                        2 => 'A room without a view',
                    ],
                    'answer' => 'A double room',
                    'explanation_vi' => 'Linh nói: \'We had a double room with a sea view.\' (Chúng tôi có một phòng đôi với view biển.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What did the tour guide show Linh?',
                    'options' => [
                        0 => 'Only the floating village',
                        1 => 'Many attractions including limestone mountains and a floating village',
                        2 => 'Only the limestone mountains',
                    ],
                    'answer' => 'Many attractions including limestone mountains and a floating village',
                    'explanation_vi' => 'Linh nói: \'Our tour guide showed us many attractions. The limestone mountains were breathtaking! We also visited a floating village.\' (Hướng dẫn viên của chúng tôi cho chúng tôi xem nhiều điểm tham quan. Những ngọn núi đá vôi ngoạn mục! Chúng tôi cũng ghé thăm một ngôi làng nổi.)',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What did Linh think about Ha Long Bay?',
                    'options' => [
                        0 => 'It was boring',
                        1 => 'It was memorable and she recommends it to everyone',
                        2 => 'It was too expensive',
                    ],
                    'answer' => 'It was memorable and she recommends it to everyone',
                    'explanation_vi' => 'Linh nói: \'It was a memorable experience. I recommend Ha Long Bay to everyone!\' (Đó là một trải nghiệm đáng nhớ. Tôi giới thiệu Vịnh Hạ Long cho mọi người!)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Linh bought some local ___ at Ha Long Bay.',
                    'options' => null,
                    'answer' => 'handicrafts',
                    'explanation_vi' => 'Linh nói: \'I bought some local handicrafts.\' (Tôi đã mua một số đồ thủ công địa phương.) Đây là những quà lưu niệm (souvenirs) từ chuyến du lịch.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'Write about Your Recent Trip',
            'title_vi' => 'Viết về Chuyến Du Lịch Gần Đây của Em',
            'instructions_en' => 'Write a short paragraph (50-80 words) about a trip you have taken recently or a trip you would like to take. Use past simple for what happened during the trip, and present perfect for your recent experiences. Include at least 3 words from the unit vocabulary.',
            'instructions_vi' => 'Viết một đoạn văn ngắn (50-80 từ) về một chuyến du lịch em đã đi gần đây hoặc một chuyến du lịch em muốn đi. Sử dụng thì quá khứ đơn để mô tả những gì xảy ra trong chuyến du lịch, và thì hiện tại hoàn thành để nói về những trải nghiệm gần đây. Bao gồm ít nhất 3 từ từ vựng của bài học.',
            'passage' => null,
            'prompt_en' => 'Write about a trip to a place in Vietnam (real or imaginary). Include:
- Where you went, when you went, and what accommodation you stayed in
- At least two attractions you visited and describe them using \'breathtaking\' or \'memorable\'
- Whether you would recommend this place to your friends and why',
            'prompt_vi' => 'Viết về một chuyến du lịch đến một địa điểm ở Việt Nam (thực tế hoặc tưởng tượng). Bao gồm:
- Nơi em đi, thời gian em đi, và chỗ ở em lưu trú
- Ít nhất hai điểm tham quan em đã thăm và mô tả chúng bằng từ \'ngoạn mục\' hoặc \'đáng nhớ\'
- Liệu em có giới thiệu địa điểm này cho bạn bè không và tại sao',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-9' => [
        'reading' => [
            'title_en' => 'English Around the World',
            'title_vi' => 'Tiếng Anh Trên Toàn Thế Giới',
            'instructions_en' => 'Read the passage about different varieties of English. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về các biến thể khác nhau của tiếng Anh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'English has many varieties around the world. British English, American English, and Australian English have different pronunciation and vocabulary. For example, British people say "flat" but American people say "apartment". Native speakers from different countries have different accents and dialects. However, they can still communicate and understand each other because the grammar is similar.

Many students have learned English as an international language. They have adapted their pronunciation to communicate with people from different countries. Some students have studied British English, while others have studied American English. All these varieties have mutual influence on each other. Learning about different varieties helps students become more fluent and confident speakers.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is one difference between British English and American English mentioned in the passage?',
                    'options' => [
                        0 => 'British people say "flat" but American people say "apartment"',
                        1 => 'British people use different grammar rules',
                        2 => 'American people have a better accent',
                        3 => 'Australian people speak British English',
                    ],
                    'answer' => 'British people say "flat" but American people say "apartment"',
                    'explanation_vi' => 'Đoạn văn nói rõ "British people say \'flat\' but American people say \'apartment\'".',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why can native speakers from different countries still understand each other?',
                    'options' => [
                        0 => 'Because they all speak with the same accent',
                        1 => 'Because the grammar is similar',
                        2 => 'Because they all learned American English',
                        3 => 'Because they have the same vocabulary',
                    ],
                    'answer' => 'Because the grammar is similar',
                    'explanation_vi' => 'Đoạn văn nói "they can still communicate and understand each other because the grammar is similar".',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What have many students done to communicate internationally?',
                    'options' => [
                        0 => 'They have changed their grammar',
                        1 => 'They have adapted their pronunciation',
                        2 => 'They have learned only British English',
                        3 => 'They have stopped learning English',
                    ],
                    'answer' => 'They have adapted their pronunciation',
                    'explanation_vi' => 'Đoạn văn nói "They have adapted their pronunciation to communicate with people from different countries".',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'True or False: All students have studied the same variety of English.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói "Some students have studied British English, while others have studied American English", vì vậy không phải tất cả học sinh đều học cùng một biến thể.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Native speakers from different countries have different ___ and dialects.',
                    'options' => null,
                    'answer' => 'accents',
                    'explanation_vi' => 'Câu trong đoạn văn là "Native speakers from different countries have different accents and dialects".',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Learning Different Varieties of English',
            'title_vi' => 'Học các biến thể khác nhau của tiếng Anh',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe nó hai lần. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! Have you studied different varieties of English?
Minh: Yes, I have! I\'ve learned about British English, American English, and Australian English.
Linh: That\'s great! Have you noticed the differences in accent and pronunciation?
Minh: Of course! American English has a different accent from British English. I\'ve also learned that vocabulary and grammar can be different too.
Linh: Have you heard native speakers from these countries?
Minh: Yes, I have. It helps me communicate better and understand international English.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What varieties of English has Minh studied?',
                    'options' => [
                        0 => 'British English, American English, and Australian English',
                        1 => 'British English and American English only',
                        2 => 'Australian English and American English only',
                    ],
                    'answer' => 'British English, American English, and Australian English',
                    'explanation_vi' => 'Minh nói: \'I\'ve learned about British English, American English, and Australian English.\' (Tôi đã học về tiếng Anh Anh, tiếng Anh Mỹ, và tiếng Anh Úc.)',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to Minh, what can be different between varieties of English?',
                    'options' => [
                        0 => 'Only accent and pronunciation',
                        1 => 'Accent, pronunciation, vocabulary, and grammar',
                        2 => 'Only vocabulary and grammar',
                    ],
                    'answer' => 'Accent, pronunciation, vocabulary, and grammar',
                    'explanation_vi' => 'Minh nói: \'I\'ve also learned that vocabulary and grammar can be different too.\' (Tôi cũng đã học rằng từ vựng và ngữ pháp cũng có thể khác nhau.) Và trước đó Linh hỏi về accent và pronunciation.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Minh listen to native speakers?',
                    'options' => [
                        0 => 'To learn about Vietnamese culture',
                        1 => 'To communicate better and understand international English',
                        2 => 'To teach other students',
                    ],
                    'answer' => 'To communicate better and understand international English',
                    'explanation_vi' => 'Minh nói: \'It helps me communicate better and understand international English.\' (Nó giúp tôi giao tiếp tốt hơn và hiểu tiếng Anh quốc tế.)',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh has ___ native speakers from different countries.',
                    'options' => null,
                    'answer' => 'heard',
                    'explanation_vi' => 'Minh nói: \'Yes, I have. It helps me communicate better and understand international English.\' Câu trước đó là \'Have you heard native speakers from these countries?\' nên câu trả lời là \'I have heard\' hoặc \'I\'ve heard\'.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Experience with English Varieties',
            'title_vi' => 'Kinh nghiệm của tôi với các biến thể tiếng Anh',
            'instructions_en' => 'Write about your experiences learning or hearing different varieties of English. Use the Present Perfect (have/has + past participle) to describe what you have done or experienced. Write 50-80 words.',
            'instructions_vi' => 'Viết về những kinh nghiệm của bạn khi học hoặc nghe các biến thể tiếng Anh khác nhau. Sử dụng Present Perfect (have/has + past participle) để mô tả những gì bạn đã làm hoặc trải qua. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your experience with different English varieties. Include:
- What varieties of English you have heard or learned (British English, American English, Australian English, etc.)
- What differences in accent, pronunciation, or vocabulary you have noticed
- How these experiences have helped you communicate better or understand English better',
            'prompt_vi' => 'Viết về kinh nghiệm của bạn với các biến thể tiếng Anh khác nhau. Bao gồm:
- Những biến thể tiếng Anh nào bạn đã nghe hoặc học (tiếng Anh Anh, tiếng Anh Mỹ, tiếng Anh Úc, v.v.)
- Những khác biệt về giọng nói, cách phát âm hoặc từ vựng mà bạn đã nhận thấy
- Những kinh nghiệm này đã giúp bạn giao tiếp tốt hơn hoặc hiểu tiếng Anh tốt hơn như thế nào',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-10' => [
        'reading' => [
            'title_en' => 'Protecting Our Planet',
            'title_vi' => 'Bảo vệ Hành tinh của chúng ta',
            'instructions_en' => 'Read the passage about environmental protection. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về bảo vệ môi trường. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Vietnam\'s natural resources are being damaged by pollution and global warming. Fossil fuels are being replaced by renewable energy in many cities. Greenhouse gases are polluting our climate, and many animals are becoming endangered. However, conservation efforts are helping to protect our planet.

Every person can reduce their carbon footprint by recycling, reusing, and reducing waste. Sustainable practices are being used in schools and factories across Vietnam. When we recycle plastic and paper, our natural resources are being saved for the future. Together, we can create a better world.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is replacing fossil fuels in many Vietnamese cities?',
                    'options' => [
                        0 => 'Renewable energy',
                        1 => 'Greenhouse gases',
                        2 => 'Natural resources',
                        3 => 'Pollution',
                    ],
                    'answer' => 'Renewable energy',
                    'explanation_vi' => 'Đoạn văn nói \'Fossil fuels are being replaced by renewable energy in many cities.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which of the following is NOT mentioned as a way to reduce carbon footprint?',
                    'options' => [
                        0 => 'Recycling',
                        1 => 'Reusing',
                        2 => 'Reducing waste',
                        3 => 'Planting trees',
                    ],
                    'answer' => 'Planting trees',
                    'explanation_vi' => 'Đoạn văn chỉ đề cập đến tái chế, tái sử dụng, và giảm chất thải.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What problem is caused by greenhouse gases?',
                    'options' => [
                        0 => 'They save natural resources',
                        1 => 'They pollute our climate',
                        2 => 'They replace fossil fuels',
                        3 => 'They help conservation',
                    ],
                    'answer' => 'They pollute our climate',
                    'explanation_vi' => 'Đoạn văn nói \'Greenhouse gases are polluting our climate.\'',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Many animals are becoming endangered because of pollution and global warming.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'True',
                    'explanation_vi' => 'Đoạn văn nói \'many animals are becoming endangered\' do ô nhiễm và nóng lên toàn cầu.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Sustainable practices are being used in schools and ___ across Vietnam.',
                    'options' => null,
                    'answer' => 'factories',
                    'explanation_vi' => 'Đoạn văn nói \'Sustainable practices are being used in schools and factories across Vietnam.\'',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Protecting Our Planet',
            'title_vi' => 'Bảo vệ Hành tinh Trái Đất',
            'instructions_en' => 'Listen to the conversation about environmental protection. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại về bảo vệ môi trường. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Linh: Hi Minh! Did you know that fossil fuels are being replaced by renewable energy in many countries?
Minh: That\'s great! But what about pollution? Is it still a big problem?
Linh: Yes, pollution is still high. Greenhouse gases are being produced by factories every day. Global warming is affecting our climate.
Minh: That\'s scary. What can we do to help?
Linh: We can reduce our carbon footprint. We should recycle, reuse, and reduce waste. Conservation of natural resources is very important.
Minh: You\'re right. Endangered animals need our help too!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is being replaced by renewable energy?',
                    'options' => [
                        0 => 'Pollution',
                        1 => 'Fossil fuels',
                        2 => 'Natural resources',
                    ],
                    'answer' => 'Fossil fuels',
                    'explanation_vi' => 'Linh nói rằng \'fossil fuels are being replaced by renewable energy\' - nhiên liệu hóa thạch đang được thay thế bằng năng lượng tái tạo.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the conversation, what is affecting our climate?',
                    'options' => [
                        0 => 'Recycling',
                        1 => 'Global warming',
                        2 => 'Renewable energy',
                    ],
                    'answer' => 'Global warming',
                    'explanation_vi' => 'Linh nói \'Global warming is affecting our climate\' - hiện tượng nóng lên toàn cầu đang ảnh hưởng đến khí hậu của chúng ta.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Which of these is NOT mentioned as a way to help the environment?',
                    'options' => [
                        0 => 'Reduce waste',
                        1 => 'Build factories',
                        2 => 'Recycle and reuse',
                    ],
                    'answer' => 'Build factories',
                    'explanation_vi' => 'Linh đề cập đến việc giảm, tái chế và tái sử dụng. Xây dựng nhà máy không được nhắc đến như một cách giúp đỡ.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'We should recycle, reuse, and ___ waste to reduce our carbon footprint.',
                    'options' => null,
                    'answer' => 'reduce',
                    'explanation_vi' => 'Linh nói \'We should recycle, reuse, and reduce waste\' - chúng ta nên tái chế, tái sử dụng và giảm chất thải.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'How We Can Help Planet Earth',
            'title_vi' => 'Cách chúng ta có thể giúp Hành tinh Trái Đất',
            'instructions_en' => 'Write a short paragraph about environmental actions. Use the passive voice to describe what is being done or what should be done to protect Earth. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn về các hành động bảo vệ môi trường. Sử dụng câu bị động để mô tả những gì đang được thực hiện hoặc những gì nên được thực hiện để bảo vệ Trái Đất. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about what is being done or what should be done to help the environment in Vietnam. Include:
- One action using passive voice (e.g., \'Fossil fuels are being replaced by renewable energy\')
- One problem that needs to be solved (use words like: pollution, global warming, greenhouse gas, endangered animals)
- One solution using passive voice (e.g., \'Plastic should be recycled\', \'Our carbon footprint can be reduced\')',
            'prompt_vi' => 'Viết về những gì đang được thực hiện hoặc những gì nên được thực hiện để giúp môi trường ở Việt Nam. Bao gồm:
- Một hành động sử dụng câu bị động (ví dụ: \'Nhiên liệu hóa thạch đang được thay thế bằng năng lượng tái tạo\')
- Một vấn đề cần được giải quyết (sử dụng các từ như: pollution, global warming, greenhouse gas, endangered animals)
- Một giải pháp sử dụng câu bị động (ví dụ: \'Nhựa nên được tái chế\', \'Dấu chân carbon của chúng ta có thể được giảm\')',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-11' => [
        'reading' => [
            'title_en' => 'Electronic Devices in Our Daily Life',
            'title_vi' => 'Thiết bị điện tử trong cuộc sống hàng ngày',
            'instructions_en' => 'Read the passage about electronic devices. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về thiết bị điện tử. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Electronic devices are used by millions of Vietnamese students every day. Smartphones, laptops, and tablets are connected to the internet to download and upload information for school work. The battery of each device is charged daily with a charger. Headphones are used to listen to music and educational videos.

However, electronic devices can be harmful if they are used too much. Many young people become addicted to these devices, and their eyes are damaged by the bright screen. Radiation from smartphones is also dangerous. But these devices are beneficial when they are used correctly. They help students improve their English and learn new skills. Balance is important!',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What electronic devices are mentioned as being connected to the internet?',
                    'options' => [
                        0 => 'Smartphones, laptops, and tablets',
                        1 => 'Headphones, chargers, and batteries',
                        2 => 'Screens, keyboards, and mice',
                        3 => 'Radios, televisions, and speakers',
                    ],
                    'answer' => 'Smartphones, laptops, and tablets',
                    'explanation_vi' => 'Đoạn văn nói rõ \'Smartphones, laptops, and tablets are connected to the internet\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the passage, how often is the battery of each device charged?',
                    'options' => [
                        0 => 'Weekly',
                        1 => 'Monthly',
                        2 => 'Daily',
                        3 => 'Every few days',
                    ],
                    'answer' => 'Daily',
                    'explanation_vi' => 'Đoạn văn viết \'The battery of each device is charged daily with a charger\'.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is one harmful effect of using electronic devices too much?',
                    'options' => [
                        0 => 'The charger breaks easily',
                        1 => 'Eyes are damaged by the bright screen',
                        2 => 'The internet connection becomes slow',
                        3 => 'Headphones become too loud',
                    ],
                    'answer' => 'Eyes are damaged by the bright screen',
                    'explanation_vi' => 'Đoạn văn nói \'their eyes are damaged by the bright screen\' khi sử dụng quá nhiều.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Electronic devices are only harmful and have no beneficial uses.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói rõ thiết bị điện tử \'are beneficial when they are used correctly\' và giúp học sinh cải thiện tiếng Anh.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Radiation from ___ is also dangerous according to the passage.',
                    'options' => null,
                    'answer' => 'smartphones',
                    'explanation_vi' => 'Đoạn văn viết \'Radiation from smartphones is also dangerous\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Electronic Devices at Home',
            'title_vi' => 'Các thiết bị điện tử ở nhà',
            'instructions_en' => 'Listen to the conversation about electronic devices. Answer the questions below.',
            'instructions_vi' => 'Nghe cuộc hội thoại về các thiết bị điện tử. Trả lời các câu hỏi dưới đây.',
            'passage' => 'Hoa: Hi Minh! What electronic devices do you use every day?
Minh: I use my smartphone and laptop. My smartphone is charged every night.
Hoa: That\'s good. Do you use headphones?
Minh: Yes, but my headphones are not connected to my laptop today. The battery is broken.
Hoa: Oh no! Is using electronic devices harmful?
Minh: Sometimes. But they are also beneficial. They help me download and upload my schoolwork.
Hoa: I agree. We should not be addicted to these devices.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'When is Minh\'s smartphone charged?',
                    'options' => [
                        0 => 'Every morning',
                        1 => 'Every night',
                        2 => 'Every afternoon',
                    ],
                    'answer' => 'Every night',
                    'explanation_vi' => 'Minh nói \'My smartphone is charged every night\' - điện thoại của Minh được sạc mỗi tối.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is wrong with Minh\'s headphones?',
                    'options' => [
                        0 => 'The screen is broken',
                        1 => 'The battery is broken',
                        2 => 'The charger is broken',
                    ],
                    'answer' => 'The battery is broken',
                    'explanation_vi' => 'Minh nói \'The battery is broken\' - pin của tai nghe bị hỏng.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'According to the conversation, are electronic devices only harmful?',
                    'options' => [
                        0 => 'Yes, they are only harmful',
                        1 => 'No, they are also beneficial',
                        2 => 'No one knows',
                    ],
                    'answer' => 'No, they are also beneficial',
                    'explanation_vi' => 'Minh nói \'Sometimes. But they are also beneficial\' - các thiết bị điện tử cũng có lợi.',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Electronic devices help Minh ___ and ___ his schoolwork.',
                    'options' => null,
                    'answer' => 'download and upload',
                    'explanation_vi' => 'Minh nói \'They help me download and upload my schoolwork\' - các thiết bị giúp tải xuống và tải lên bài tập.',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'How Electronic Devices Are Used in My Daily Life',
            'title_vi' => 'Cách sử dụng thiết bị điện tử trong cuộc sống hàng ngày của tôi',
            'instructions_en' => 'Write about how electronic devices are used in your daily life. Use passive voice (be + past participle) to describe what happens to these devices. Write 50-80 words.',
            'instructions_vi' => 'Viết về cách sử dụng thiết bị điện tử trong cuộc sống hàng ngày của bạn. Sử dụng câu bị động (be + past participle) để mô tả những gì xảy ra với các thiết bị này. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your electronic devices and how they are used. Include:
- At least two devices (smartphone, laptop, tablet, headphones) and what they are used for
- How these devices are charged or connected
- One benefit or one harmful effect of using these devices',
            'prompt_vi' => 'Viết về các thiết bị điện tử của bạn và cách chúng được sử dụng. Bao gồm:
- Ít nhất hai thiết bị (điện thoại thông minh, máy tính xách tay, máy tính bảng, tai nghe) và chúng được dùng để làm gì
- Cách các thiết bị này được sạc hoặc kết nối
- Một lợi ích hoặc một tác hại của việc sử dụng các thiết bị này',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
    '9-12' => [
        'reading' => [
            'title_en' => 'Minh\'s Career Plan',
            'title_vi' => 'Kế hoạch sự nghiệp của Minh',
            'instructions_en' => 'Read the passage about Minh\'s future career. Then answer the questions below.',
            'instructions_vi' => 'Đọc đoạn văn về sự nghiệp tương lai của Minh. Sau đó trả lời các câu hỏi dưới đây.',
            'passage' => 'Minh is an ambitious student in grade 9. He is going to pursue a career as an engineer because he loves building things and solving problems. His main strengths are his creative skills and his ability to work with numbers. However, he knows his weakness is that he is not very good at English. Minh will study hard this year to improve his English skills. He plans to achieve his dream by going to university and becoming a responsible engineer. His parents support his plan because they believe he will be successful in this profession.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What career is Minh going to pursue?',
                    'options' => [
                        0 => 'architect',
                        1 => 'engineer',
                        2 => 'accountant',
                        3 => 'lawyer',
                    ],
                    'answer' => 'engineer',
                    'explanation_vi' => 'Đoạn văn nói rõ \'He is going to pursue a career as an engineer\'.',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Minh want to be an engineer?',
                    'options' => [
                        0 => 'Because he wants to make a lot of money',
                        1 => 'Because his parents want him to',
                        2 => 'Because he loves building things and solving problems',
                        3 => 'Because it is an easy job',
                    ],
                    'answer' => 'Because he loves building things and solving problems',
                    'explanation_vi' => 'Đoạn văn nói \'he loves building things and solving problems\' là lý do của Minh.',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Minh\'s weakness?',
                    'options' => [
                        0 => 'He is not creative',
                        1 => 'He is not good at mathematics',
                        2 => 'He is not good at English',
                        3 => 'He is not responsible',
                    ],
                    'answer' => 'He is not good at English',
                    'explanation_vi' => 'Đoạn văn nói \'his weakness is that he is not very good at English\'.',
                ],
                3 => [
                    'type' => 'true_false',
                    'prompt' => 'Minh\'s parents do not support his career plan.',
                    'options' => [
                        0 => 'True',
                        1 => 'False',
                    ],
                    'answer' => 'False',
                    'explanation_vi' => 'Đoạn văn nói \'His parents support his plan\' nên câu này sai.',
                ],
                4 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh will study hard this year to improve his ___ skills.',
                    'options' => null,
                    'answer' => 'English',
                    'explanation_vi' => 'Đoạn văn nói \'he will study hard this year to improve his English skills\'.',
                ],
            ],
        ],
        'listening' => [
            'title_en' => 'Linh and Minh talk about their future careers',
            'title_vi' => 'Linh và Minh nói chuyện về sự nghiệp tương lai',
            'instructions_en' => 'Listen to the conversation. You will hear it twice. Then answer the questions.',
            'instructions_vi' => 'Nghe cuộc hội thoại. Bạn sẽ nghe nó hai lần. Sau đó trả lời các câu hỏi.',
            'passage' => 'Linh: Hi Minh! What job are you going to pursue after school?
Minh: I want to be an engineer because I am good at math and science. What about you?
Linh: I am going to be an architect. I love drawing and I am very creative.
Minh: That\'s great! Architecture is a good profession. What are your strengths?
Linh: My strength is that I can design beautiful buildings. But my weakness is that I am not very good with numbers.
Minh: Don\'t worry! We will both achieve our dreams because we are ambitious and responsible.',
            'prompt_en' => null,
            'prompt_vi' => null,
            'min_words' => null,
            'questions' => [
                0 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What job is Minh going to pursue?',
                    'options' => [
                        0 => 'An architect',
                        1 => 'An engineer',
                        2 => 'An accountant',
                    ],
                    'answer' => 'An engineer',
                    'explanation_vi' => 'Minh nói \'I want to be an engineer because I am good at math and science.\'',
                ],
                1 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'Why does Linh want to be an architect?',
                    'options' => [
                        0 => 'Because she is good at math',
                        1 => 'Because she loves drawing and is creative',
                        2 => 'Because she is responsible',
                    ],
                    'answer' => 'Because she loves drawing and is creative',
                    'explanation_vi' => 'Linh nói \'I love drawing and I am very creative.\'',
                ],
                2 => [
                    'type' => 'multiple_choice',
                    'prompt' => 'What is Linh\'s weakness?',
                    'options' => [
                        0 => 'She cannot draw well',
                        1 => 'She is not creative',
                        2 => 'She is not very good with numbers',
                    ],
                    'answer' => 'She is not very good with numbers',
                    'explanation_vi' => 'Linh nói \'my weakness is that I am not very good with numbers.\'',
                ],
                3 => [
                    'type' => 'gap_fill',
                    'prompt' => 'Minh says they will both achieve their dreams because they are ambitious and ___.',
                    'options' => null,
                    'answer' => 'responsible',
                    'explanation_vi' => 'Minh nói \'We will both achieve our dreams because we are ambitious and responsible.\'',
                ],
            ],
        ],
        'writing' => [
            'title_en' => 'My Future Career Plan',
            'title_vi' => 'Kế hoạch sự nghiệp tương lai của tôi',
            'instructions_en' => 'Write a short paragraph about your future career. Use \'be going to\' or \'will\' to talk about your plans, and use \'because\' to explain your reasons. Write 50-80 words.',
            'instructions_vi' => 'Viết một đoạn văn ngắn về sự nghiệp tương lai của bạn. Sử dụng \'be going to\' hoặc \'will\' để nói về kế hoạch của bạn, và sử dụng \'because\' để giải thích lý do. Viết 50-80 từ.',
            'passage' => null,
            'prompt_en' => 'Write about your future career choice. Include:
- What job or profession you are going to pursue or will choose, and why (use \'because\')
- One or two of your strengths or skills that will help you achieve this career
- What you plan to do to prepare for this career',
            'prompt_vi' => 'Viết về lựa chọn sự nghiệp tương lai của bạn. Bao gồm:
- Công việc hoặc nghề nghiệp nào bạn sẽ theo đuổi hoặc sẽ chọn, và tại sao (sử dụng \'because\')
- Một hoặc hai điểm mạnh hoặc kỹ năng của bạn sẽ giúp bạn đạt được sự nghiệp này
- Bạn lên kế hoạch làm gì để chuẩn bị cho sự nghiệp này',
            'min_words' => 50,
            'questions' => [
            ],
        ],
    ],
];
