<?php

return [
    'title' => 'Hướng dẫn sử dụng',
    'meta_description' => 'Hướng dẫn sử dụng English Buddy cho học sinh, giáo viên và quản trị viên: đăng nhập, luyện nói với bạn AI, làm bài, tạo lớp, soạn và giao bài.',
    'intro' => 'Tài liệu này chỉ cách dùng English Buddy cho học sinh, giáo viên và quản trị viên. Tên in đậm là tên nút hoặc mục đúng như trên màn hình.',
    'contents' => 'Mục lục',
    'tips' => 'Lưu ý',

    'parts' => [
        [
            'id' => 'getting-started',
            'title' => 'Bắt đầu',
            'intro' => 'Những điều mọi người dùng cần biết trước khi vào học.',
            'topics' => [
                [
                    'id' => 'sign-in',
                    'title' => 'Tài khoản và đăng nhập',
                    'body' => 'English Buddy không có đăng ký tự do. Học sinh nhận tài khoản từ giáo viên, giáo viên nhận tài khoản từ quản trị viên.',
                    'steps' => [
                        'Bấm **Đăng nhập** ở góc trên của trang. Trang mở ra là trang dành cho học sinh.',
                        'Nếu là giáo viên hoặc quản trị viên, bấm dòng **Bạn là giáo viên hoặc quản trị viên? Đăng nhập tại đây** ở cuối khung đăng nhập.',
                        'Nhập **Tên đăng nhập** và **Mật khẩu**, rồi bấm **Đăng nhập**.',
                    ],
                    'tips' => [
                        'Học sinh chỉ đăng nhập được ở trang học sinh, giáo viên và quản trị viên chỉ đăng nhập được ở trang của mình.',
                        'Nhập sai nhiều lần liên tiếp sẽ bị tạm khóa trong một thời gian ngắn. Hãy đợi theo số giây trên màn hình rồi thử lại.',
                        'Trên máy tính dùng chung, không chọn **Ghi nhớ đăng nhập** và nhớ đăng xuất sau khi học.',
                    ],
                ],
                [
                    'id' => 'requirements',
                    'title' => 'Thiết bị cần có',
                    'body' => 'Nên dùng máy tính có loa và micro. Để nói qua micro cần dùng **Chrome** hoặc **Edge**. Trên trình duyệt khác, em gõ câu trả lời bằng bàn phím và nhân vật vẫn nói bình thường.',
                    'tips' => [
                        'Lần đầu bấm nghe, máy có thể cần tải giọng đọc và mất ít phút.',
                    ],
                ],
                [
                    'id' => 'language',
                    'title' => 'Đổi ngôn ngữ giao diện',
                    'body' => 'Bấm **VI** hoặc **EN** ở cuối menu bên trái, hoặc ở góc trên khi chưa đăng nhập. Phần mềm nhớ lựa chọn này cho tài khoản của bạn. Câu tiếng Anh và nghĩa tiếng Việt trong bài học vẫn giữ song ngữ ở cả hai chế độ.',
                ],
                [
                    'id' => 'password',
                    'title' => 'Đổi mật khẩu',
                    'steps' => [
                        'Bấm biểu tượng chìa khóa cạnh tên của bạn ở cuối menu bên trái.',
                        'Nhập mật khẩu hiện tại, rồi nhập mật khẩu mới hai lần. Mật khẩu mới cần có ít nhất 8 ký tự.',
                        'Bấm **Lưu mật khẩu mới**.',
                    ],
                    'tips' => [
                        'Quên mật khẩu: học sinh báo giáo viên, giáo viên báo quản trị viên để được cấp mật khẩu mới.',
                    ],
                ],
            ],
        ],
        [
            'id' => 'students',
            'title' => 'Dành cho học sinh',
            'intro' => 'Em có thể học theo unit trên lớp, luyện theo chủ đề giao tiếp, hoặc làm bài thầy cô giao.',
            'topics' => [
                [
                    'id' => 'student-home',
                    'title' => 'Trang Tổng quan',
                    'body' => 'Sau khi đăng nhập, **Tổng quan** cho em thấy tiến độ, các cuộc hội thoại gần đây, chủ đề gợi ý và bài được giao.',
                ],
                [
                    'id' => 'student-units',
                    'title' => 'Học theo unit',
                    'steps' => [
                        'Vào **Chương trình** trên menu. Em sẽ thấy các unit của khối mình, chia theo học kỳ.',
                        'Bấm vào một unit. Phần **Nội dung trọng tâm của unit** có từ vựng và ngữ pháp, bấm loa để nghe từng từ.',
                        'Ở phần **Nói**, bấm **Gọi** cạnh một tình huống để luyện nói.',
                        'Ở các phần **Nghe**, **Đọc**, **Viết**, bấm vào tên bài để làm.',
                    ],
                ],
                [
                    'id' => 'student-topics',
                    'title' => 'Học mẫu câu theo chủ đề',
                    'steps' => [
                        'Vào **Chủ đề giao tiếp** và chọn một chủ đề.',
                        'Chọn mức hỗ trợ: **Đầy đủ** hiện toàn bộ nghĩa tiếng Việt, **Gợi ý** chỉ hiện vài chữ đầu, **Chỉ tiếng Anh** ẩn nghĩa.',
                        'Bấm loa để nghe câu. Khi chưa hiểu, bấm **Xem nghĩa** ở đúng câu đó.',
                        'Khi đã quen, bấm **Bắt đầu nhập vai** ở một tình huống bên cạnh.',
                    ],
                ],
                [
                    'id' => 'student-call',
                    'title' => 'Gọi điện luyện nói với nhân vật',
                    'steps' => [
                        'Lần đầu, chọn một nhân vật: Mèo Miu, Robo, Khủng long Dino hoặc Cú Oli. Muốn đổi thì bấm **Đổi bạn** trước khi gọi.',
                        'Bật loa, bấm **Gọi cho** tên nhân vật và cho phép trình duyệt dùng micro.',
                        'Nhân vật nói xong thì micro tự bật. Em nói bằng tiếng Anh. Sau khoảng 4 giây im lặng, câu sẽ tự gửi đi.',
                        'Nói xong sớm thì bấm **Em nói xong**. Muốn nói lại câu vừa rồi thì bấm **Nói lại**.',
                        'Khi không biết nói gì, bấm **Gợi ý cho em** để xem một câu mẫu kèm nghĩa.',
                        'Bấm **Kết thúc cuộc gọi** khi muốn dừng. Em có thể bấm **Gọi lại** để tiếp tục.',
                    ],
                    'tips' => [
                        'Mỗi tình huống có tối đa 12 lượt nói.',
                        'Trong lúc gọi có thể dùng **Tạm dừng micro**, **Ẩn phụ đề**, **Nghe lại** và **Gõ chữ**.',
                        'Mở mục **Lời thoại** ở cuối khung gọi để đọc lại toàn bộ cuộc trò chuyện.',
                    ],
                ],
                [
                    'id' => 'student-feedback',
                    'title' => 'Xem nhận xét của AI',
                    'steps' => [
                        'Nói ít nhất 2 câu rồi kết thúc cuộc gọi.',
                        'Bấm **Nhờ AI nhận xét**.',
                        'Đọc từng câu: câu nên sửa có cách nói tốt hơn và giải thích bằng tiếng Việt. Bấm loa để nghe câu đã sửa.',
                    ],
                    'tips' => [
                        'Vào **Hội thoại của em** để xem lại các cuộc gọi cũ và nhận xét của AI.',
                    ],
                ],
                [
                    'id' => 'student-assignments',
                    'title' => 'Làm bài thầy cô giao',
                    'steps' => [
                        'Vào **Bài được giao** để xem bài và hạn nộp.',
                        'Bấm **Làm bài**, trả lời hết các câu rồi bấm **Nộp bài**.',
                        'Xem kết quả và đáp án. Muốn cải thiện điểm thì bấm **Làm lại**.',
                    ],
                    'tips' => [
                        'Bài Nghe: bấm **Nghe bài** và nghe lại bao nhiêu lần cũng được.',
                        'Bài Viết: cần viết đủ số từ tối thiểu mới nộp được, AI sẽ chấm và góp ý.',
                        'Câu sắp xếp từ: bấm các từ theo đúng thứ tự, bấm **Xếp lại** để làm lại câu đó.',
                    ],
                ],
            ],
        ],
        [
            'id' => 'teachers',
            'title' => 'Dành cho giáo viên',
            'intro' => 'Thầy cô tạo lớp, kiểm tra nội dung, soạn hoặc chọn bài, giao cho lớp và theo dõi kết quả.',
            'topics' => [
                [
                    'id' => 'teacher-classes',
                    'title' => 'Tạo lớp và cấp tài khoản cho học sinh',
                    'steps' => [
                        'Vào **Lớp học**, nhập **Tên lớp**, chọn **Khối** rồi bấm **Tạo lớp**.',
                        'Mở lớp vừa tạo. Ở phần **Thêm học sinh**, nhập họ tên, mỗi dòng một em.',
                        'Bấm **Tạo tài khoản**. Bảng tên đăng nhập và mật khẩu hiện ra.',
                        'Bấm **In** hoặc chép lại ngay để phát cho học sinh.',
                    ],
                    'tips' => [
                        'Mật khẩu chỉ hiện một lần. Nếu học sinh mất mật khẩu, bấm **Đặt lại mật khẩu** ở dòng của em đó để tạo mật khẩu mới.',
                        'Mỗi lần thêm được tối đa 60 học sinh.',
                    ],
                ],
                [
                    'id' => 'teacher-focus',
                    'title' => 'Kiểm tra từ vựng và ngữ pháp của unit',
                    'body' => 'Bài luyện do AI tạo chỉ dùng đúng từ và cấu trúc đã lưu ở đây, nên thầy cô nên đối chiếu với sách của lớp.',
                    'steps' => [
                        'Vào **Chương trình**, chọn khối rồi chọn unit.',
                        'Ở **Nội dung trọng tâm của unit**, bấm **Sửa**, hoặc **Nhập từ vựng** nếu unit chưa có từ.',
                        'Mỗi dòng một từ theo dạng `từ (loại từ) = nghĩa tiếng Việt`, rồi điền ngữ pháp.',
                        'Bấm **Lưu**.',
                    ],
                    'tips' => [
                        'Bấm **AI gợi ý** để có danh sách nháp, sau đó đối chiếu với sách và sửa lại trước khi lưu.',
                    ],
                ],
                [
                    'id' => 'teacher-ai',
                    'title' => 'Tạo bài bằng AI',
                    'steps' => [
                        'Mở một unit đã có từ vựng.',
                        'Với Nghe, Đọc, Viết: bấm **Tạo bài tập bằng AI** ở thẻ kỹ năng tương ứng. Bài tạo ra chỉ đến với học sinh khi thầy cô giao bài.',
                        'Với Nói: bấm **Tạo bài nói bằng AI**, xem các câu mẫu, rồi bấm **Cho học sinh luyện** để mở cho cả khối.',
                        'Bấm **Ngừng cho luyện** khi muốn đóng bài nói lại.',
                    ],
                ],
                [
                    'id' => 'teacher-edit',
                    'title' => 'Sửa hoặc xoá bài',
                    'steps' => [
                        'Trong unit, bấm biểu tượng bút ở dòng bài tập.',
                        'Sửa tên bài, lời dẫn, đoạn đọc hoặc lời thoại, và từng câu hỏi cùng đáp án.',
                        'Bấm **Lưu bài**. Học sinh sẽ thấy đúng những gì thầy cô lưu.',
                    ],
                    'tips' => [
                        'Bài đã có học sinh làm thì không xoá được. Thầy cô có thể bấm **Huỷ giao** để gỡ bài khỏi lớp.',
                    ],
                ],
                [
                    'id' => 'teacher-write',
                    'title' => 'Tự soạn bài tập',
                    'steps' => [
                        'Vào **Tạo bài tập** và chọn **Tự soạn**.',
                        'Chọn **Khối**, **Unit (không bắt buộc)** và **Loại bài**, rồi bấm **Tạo bài trống**.',
                        'Bấm **Thêm câu hỏi** và chọn dạng: trắc nghiệm, đúng/sai, điền từ, sắp xếp từ thành câu, viết lại câu, nối, phát âm/trọng âm.',
                        'Làm theo gợi ý hiện dưới mỗi dạng câu hỏi, rồi bấm **Lưu bài**.',
                    ],
                    'tips' => [
                        'Bài tự soạn là của riêng thầy cô. Học sinh chỉ thấy khi được giao.',
                    ],
                ],
                [
                    'id' => 'teacher-upload',
                    'title' => 'Chuyển ảnh hoặc PDF đề thành bài tập',
                    'steps' => [
                        'Vào **Tạo bài tập** và chọn **Từ ảnh hoặc file PDF đề**.',
                        'Chọn tối đa 5 ảnh JPG, PNG hoặc 1 file PDF, mỗi file không quá 10 MB.',
                        'Đánh dấu hai ô xác nhận: đề do thầy cô hoặc nhà trường tự soạn, và đề còn trống, không có thông tin học sinh.',
                        'Bấm **Đọc đề** và chờ khoảng một phút.',
                        'Đối chiếu từng câu với đề gốc hiện bên cạnh, nhất là các câu có nhãn **Cần kiểm tra**, rồi bấm **Lưu bài**.',
                    ],
                    'tips' => [
                        'Không tải lên trang chụp từ sách Global Success hay sách bài tập.',
                        'Đề tải lên được đọc thành bài Ngữ pháp & từ vựng, Đọc hoặc Nghe. Bài Viết thì chọn **Tự soạn**.',
                        'Bài còn câu **Cần kiểm tra** chưa lưu lại thì chưa giao được.',
                    ],
                ],
                [
                    'id' => 'teacher-assign',
                    'title' => 'Giao bài cho lớp',
                    'steps' => [
                        'Mở bài tập. Ở phần **Giao bài cho lớp**, đánh dấu một hoặc nhiều lớp.',
                        'Đặt **Hạn nộp** nếu cần.',
                        'Bấm **Giao bài**. Học sinh của lớp thấy bài ngay ở mục **Bài được giao**.',
                    ],
                    'tips' => [
                        'Bấm **Huỷ giao** để gỡ bài khỏi lớp. Các lần làm bài của học sinh vẫn được giữ.',
                    ],
                ],
                [
                    'id' => 'teacher-results',
                    'title' => 'Xem kết quả',
                    'body' => 'Vào **Bài đã giao** và mở một bài. Trang kết quả cho biết số em đã làm, điểm trung bình của lớp, và với từng học sinh là điểm cao nhất, số lần làm, lần làm gần nhất, có nộp muộn hay không. Trang **Tổng quan** tóm tắt tình hình các lớp của thầy cô.',
                ],
            ],
        ],
        [
            'id' => 'administrators',
            'title' => 'Dành cho quản trị viên',
            'intro' => 'Quản trị viên có thêm mục Giáo viên trong menu Giảng dạy.',
            'topics' => [
                [
                    'id' => 'admin-reset',
                    'title' => 'Đặt lại mật khẩu cho giáo viên',
                    'steps' => [
                        'Vào **Giáo viên** trên menu.',
                        'Bấm **Đặt lại mật khẩu** ở dòng của giáo viên và xác nhận.',
                        'Chép mật khẩu mới và gửi cho giáo viên.',
                    ],
                    'tips' => [
                        'Mật khẩu mới chỉ hiện một lần, và mật khẩu cũ ngừng hoạt động ngay.',
                    ],
                ],
            ],
        ],
        [
            'id' => 'troubleshooting',
            'title' => 'Khi gặp sự cố',
            'intro' => 'Cách xử lý những tình huống hay gặp.',
            'topics' => [
                [
                    'id' => 'no-sound',
                    'title' => 'Bấm loa nhưng không nghe thấy gì',
                    'body' => 'Kiểm tra âm lượng của máy. Lần đầu dùng, máy có thể đang tải giọng đọc, hãy đợi ít phút. Nếu màn hình báo không phát được, hãy kiểm tra mạng rồi bấm lại.',
                ],
                [
                    'id' => 'no-microphone',
                    'title' => 'Micro không hoạt động',
                    'body' => 'Dùng Chrome hoặc Edge, và cho phép trang này dùng micro trong phần cài đặt của trình duyệt. Trong lúc đó em vẫn luyện được bằng nút **Gõ chữ**.',
                ],
                [
                    'id' => 'ai-busy',
                    'title' => 'Màn hình báo trợ lý đang bận',
                    'body' => 'Dịch vụ AI tạm thời không phản hồi. Hãy đợi một lát rồi thử lại. Các phần không dùng AI như mẫu câu và bài trắc nghiệm vẫn dùng được.',
                ],
                [
                    'id' => 'cannot-sign-in',
                    'title' => 'Không đăng nhập được',
                    'body' => 'Kiểm tra lại đã vào đúng trang đăng nhập cho vai trò của mình chưa, vì tài khoản ở sai trang cũng báo sai mật khẩu. Nếu vẫn không được, hãy nhờ giáo viên hoặc quản trị viên cấp mật khẩu mới.',
                ],
                [
                    'id' => 'missing-content',
                    'title' => 'Không thấy bài hoặc unit cần tìm',
                    'body' => 'Học sinh chỉ thấy các unit của khối mình và những bài đã được mở hoặc được giao. Nếu thiếu bài, hãy báo thầy cô để kiểm tra lớp và việc giao bài.',
                ],
            ],
        ],
    ],
];
