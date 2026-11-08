<?php

return [
    'title' => 'User guide',
    'meta_description' => 'How to use English Buddy as a student, teacher or administrator: signing in, practising with an AI friend, doing exercises, creating classes, and writing and assigning work.',
    'intro' => 'This guide shows students, teachers and administrators how to use English Buddy. Names in bold are buttons or menu items exactly as they appear on screen.',
    'contents' => 'Contents',
    'tips' => 'Good to know',

    'parts' => [
        [
            'id' => 'getting-started',
            'title' => 'Getting started',
            'intro' => 'What everyone needs to know before starting.',
            'topics' => [
                [
                    'id' => 'sign-in',
                    'title' => 'Accounts and signing in',
                    'body' => 'English Buddy has no open registration. Students get an account from their teacher, and teachers get one from an administrator.',
                    'steps' => [
                        'Press **Sign in** at the top of the page. This opens the student page.',
                        'If you are a teacher or administrator, press **Are you a teacher or administrator? Sign in here** at the bottom of the sign-in box.',
                        'Enter your **Username** and **Password**, then press **Sign in**.',
                    ],
                    'tips' => [
                        'Students can only sign in on the student page; teachers and administrators only on theirs.',
                        'Too many wrong attempts lock sign-in for a short while. Wait the number of seconds shown, then try again.',
                        'On a shared computer, do not tick **Remember me**, and sign out when you finish.',
                    ],
                ],
                [
                    'id' => 'requirements',
                    'title' => 'What you need',
                    'body' => 'Use a computer with speakers and a microphone. Speaking through the microphone needs **Chrome** or **Edge**. In other browsers you type your answers and the character still speaks.',
                    'tips' => [
                        'The first time you press a speaker, the computer may need a few minutes to download the voice.',
                    ],
                ],
                [
                    'id' => 'language',
                    'title' => 'Changing the interface language',
                    'body' => 'Press **VI** or **EN** at the bottom of the left menu, or at the top of the page when signed out. The choice is remembered for your account. English sentences and their Vietnamese meanings stay bilingual in both modes.',
                ],
                [
                    'id' => 'password',
                    'title' => 'Changing your password',
                    'steps' => [
                        'Press the key icon next to your name at the bottom of the left menu.',
                        'Enter your current password, then the new one twice. The new password needs at least 8 characters.',
                        'Press **Save new password**.',
                    ],
                    'tips' => [
                        'Forgot your password? Students ask their teacher, and teachers ask an administrator, for a new one.',
                    ],
                ],
            ],
        ],
        [
            'id' => 'students',
            'title' => 'For students',
            'intro' => 'You can study by unit, practise by communication topic, or do the work your teacher sets.',
            'topics' => [
                [
                    'id' => 'student-home',
                    'title' => 'The Dashboard',
                    'body' => 'After signing in, the **Dashboard** shows your progress, recent conversations, suggested topics and assigned work.',
                ],
                [
                    'id' => 'student-units',
                    'title' => 'Studying by unit',
                    'steps' => [
                        'Open **Syllabus** in the menu. You see the units of your grade, grouped by term.',
                        'Press a unit. **What this unit teaches** lists the vocabulary and grammar; press a speaker to hear a word.',
                        'Under **Speaking**, press **Call** next to a situation to practise.',
                        'Under **Listening**, **Reading** and **Writing**, press the name of an exercise to do it.',
                    ],
                ],
                [
                    'id' => 'student-topics',
                    'title' => 'Learning sentences by topic',
                    'steps' => [
                        'Open **Communication topics** and choose one.',
                        'Choose a support level: **Full** shows the whole Vietnamese meaning, **Hints** only its first words, **English only** hides it.',
                        'Press a speaker to hear a sentence. If you do not understand one, press **Show meaning** on that sentence.',
                        'When you are ready, press **Start role-play** on one of the situations alongside.',
                    ],
                ],
                [
                    'id' => 'student-call',
                    'title' => 'Calling a character to practise speaking',
                    'steps' => [
                        'The first time, choose a character: Miu the Cat, Robo, Dino the Dinosaur or Oli the Owl. To switch, press **Change friend** before calling.',
                        'Turn your sound on, press **Call** and the character’s name, and allow the browser to use the microphone.',
                        'When the character stops speaking, the microphone opens by itself. Speak in English. After about 4 seconds of silence, your sentence is sent.',
                        'Finished early? Press **I’m done**. Want to redo the sentence? Press **Say it again**.',
                        'If you are stuck, press **Give me a hint** to see a sample sentence with its meaning.',
                        'Press **End call** to stop. You can press **Call again** to carry on.',
                    ],
                    'tips' => [
                        'Each situation allows at most 12 turns.',
                        'During a call you can use **Pause microphone**, **Hide subtitles**, **Hear again** and **Type**.',
                        'Open **Transcript** at the bottom of the call to read the whole conversation.',
                    ],
                ],
                [
                    'id' => 'student-feedback',
                    'title' => 'Reading the AI’s feedback',
                    'steps' => [
                        'Say at least 2 sentences, then end the call.',
                        'Press **Ask the AI for feedback**.',
                        'Read each sentence: those to improve come with a better version and a Vietnamese explanation. Press a speaker to hear the better version.',
                    ],
                    'tips' => [
                        'Open **My conversations** to see earlier calls and the AI’s feedback.',
                    ],
                ],
                [
                    'id' => 'student-assignments',
                    'title' => 'Doing the work your teacher sets',
                    'steps' => [
                        'Open **Assigned to me** to see your work and due dates.',
                        'Press **Start**, answer every question, then press **Hand in**.',
                        'See your result and the answers. Press **Try again** to improve your score.',
                    ],
                    'tips' => [
                        'Listening: press **Play**, and listen as many times as you like.',
                        'Writing: you need the minimum number of words to hand in, then the AI marks your work and gives feedback.',
                        'Word order questions: press the words in the right order, or **Start again** to redo that question.',
                    ],
                ],
            ],
        ],
        [
            'id' => 'teachers',
            'title' => 'For teachers',
            'intro' => 'Create classes, check content, write or pick exercises, assign them and follow the results.',
            'topics' => [
                [
                    'id' => 'teacher-classes',
                    'title' => 'Creating a class and student accounts',
                    'steps' => [
                        'Open **Classes**, enter a **Class name**, choose a **Grade** and press **Create class**.',
                        'Open the new class. Under **Add students**, type one student name per line.',
                        'Press **Create accounts**. A table of usernames and passwords appears.',
                        'Press **Print** or copy them straight away to hand out.',
                    ],
                    'tips' => [
                        'Passwords are shown only once. If a student loses theirs, press **Reset password** on that student’s row to create a new one.',
                        'You can add at most 60 students at a time.',
                    ],
                ],
                [
                    'id' => 'teacher-focus',
                    'title' => 'Checking a unit’s vocabulary and grammar',
                    'body' => 'AI-made practice uses only the words and structures saved here, so compare them with your class’s book.',
                    'steps' => [
                        'Open **Syllabus**, choose a grade, then a unit.',
                        'Under **What this unit teaches**, press **Edit**, or **Add vocabulary** if the unit has none yet.',
                        'Put one word per line as `word (part of speech) = Vietnamese meaning`, then fill in the grammar.',
                        'Press **Save**.',
                    ],
                    'tips' => [
                        'Press **Suggest with AI** for a starting list, then check it against your book and correct it before saving.',
                    ],
                ],
                [
                    'id' => 'teacher-ai',
                    'title' => 'Creating exercises with AI',
                    'steps' => [
                        'Open a unit that has vocabulary.',
                        'For Listening, Reading and Writing: press **Create with AI** on that skill’s card. The result reaches students only when you assign it.',
                        'For Speaking: press **Create speaking with AI**, check the sentences, then press **Open to students** to open it to the whole grade.',
                        'Press **Close to students** when you want to close a speaking lesson.',
                    ],
                ],
                [
                    'id' => 'teacher-edit',
                    'title' => 'Editing or deleting an exercise',
                    'steps' => [
                        'In the unit, press the pencil icon on the exercise’s row.',
                        'Change the title, instructions, passage or script, and each question and its answer.',
                        'Press **Save**. Students see exactly what you save.',
                    ],
                    'tips' => [
                        'An exercise students have already done cannot be deleted. You can press **Remove** to take it away from a class.',
                    ],
                ],
                [
                    'id' => 'teacher-write',
                    'title' => 'Writing your own exercise',
                    'steps' => [
                        'Open **New exercise** and choose **Write it myself**.',
                        'Choose the **Grade**, **Unit (optional)** and **Kind of exercise**, then press **Create an empty exercise**.',
                        'Press **Add a question** and pick a type: multiple choice, true/false, gap fill, word order, rewriting, matching, or pronunciation/stress.',
                        'Follow the hint shown under each question type, then press **Save**.',
                    ],
                    'tips' => [
                        'An exercise you write is yours. Students only see it once you assign it.',
                    ],
                ],
                [
                    'id' => 'teacher-upload',
                    'title' => 'Turning a photo or PDF of a test into an exercise',
                    'steps' => [
                        'Open **New exercise** and choose **From a photo or PDF of a test**.',
                        'Choose up to 5 JPG or PNG photos, or 1 PDF, at most 10 MB each.',
                        'Tick the two confirmations: you or your school wrote the test, and it is blank with no student details.',
                        'Press **Read the test** and wait about a minute.',
                        'Compare each question with the original shown alongside, especially those labelled **Check this**, then press **Save**.',
                    ],
                    'tips' => [
                        'Do not upload pages photographed from the Global Success books or workbooks.',
                        'An uploaded test becomes a Vocabulary & grammar, Reading or Listening exercise. For Writing, choose **Write it myself**.',
                        'An exercise with **Check this** questions cannot be assigned until you have saved it.',
                    ],
                ],
                [
                    'id' => 'teacher-assign',
                    'title' => 'Assigning work to a class',
                    'steps' => [
                        'Open the exercise. Under **Assign to a class**, tick one or more classes.',
                        'Set a **Due date** if you want one.',
                        'Press **Assign**. Students in those classes see it straight away under **Assigned to me**.',
                    ],
                    'tips' => [
                        'Press **Remove** to take it away from a class. Students’ attempts are kept.',
                    ],
                ],
                [
                    'id' => 'teacher-results',
                    'title' => 'Following the results',
                    'body' => 'Open **Assignments** and choose one. The results page shows how many students have done it, the class average and, for each student, the best score, number of attempts, last attempt and whether they were late. The **Dashboard** summarises your classes.',
                ],
            ],
        ],
        [
            'id' => 'administrators',
            'title' => 'For administrators',
            'intro' => 'Administrators have an extra Teachers item in the Teach menu.',
            'topics' => [
                [
                    'id' => 'admin-reset',
                    'title' => 'Resetting a teacher’s password',
                    'steps' => [
                        'Open **Teachers** in the menu.',
                        'Press **Reset password** on the teacher’s row and confirm.',
                        'Copy the new password and pass it on to the teacher.',
                    ],
                    'tips' => [
                        'The new password is shown only once, and the old one stops working straight away.',
                    ],
                ],
            ],
        ],
        [
            'id' => 'troubleshooting',
            'title' => 'If something goes wrong',
            'intro' => 'What to do in the most common situations.',
            'topics' => [
                [
                    'id' => 'no-sound',
                    'title' => 'I press a speaker and hear nothing',
                    'body' => 'Check the computer’s volume. The first time, the voice may still be downloading, so wait a few minutes. If the screen says the voice could not play, check the connection and press again.',
                ],
                [
                    'id' => 'no-microphone',
                    'title' => 'The microphone does not work',
                    'body' => 'Use Chrome or Edge, and allow this site to use the microphone in the browser’s settings. Meanwhile you can keep practising with the **Type** button.',
                ],
                [
                    'id' => 'ai-busy',
                    'title' => 'The screen says the assistant is busy',
                    'body' => 'The AI service is not responding for the moment. Wait a little and try again. Parts that do not use the AI, such as sentences and multiple-choice exercises, still work.',
                ],
                [
                    'id' => 'cannot-sign-in',
                    'title' => 'I cannot sign in',
                    'body' => 'Check that you are on the sign-in page for your role, because an account on the wrong page also shows a wrong-password message. If it still fails, ask your teacher or an administrator for a new password.',
                ],
                [
                    'id' => 'missing-content',
                    'title' => 'I cannot find a unit or an exercise',
                    'body' => 'Students only see the units of their own grade and the work that has been opened or assigned to them. If something is missing, ask your teacher to check your class and the assignment.',
                ],
            ],
        ],
    ],
];
