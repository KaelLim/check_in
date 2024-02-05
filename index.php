<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文宣營報到</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="title">文宣營報到</h1>
            <form id="registrationForm">
                <div class="input-field">
                    <label for="name">姓名</label>
                    <input type="text" id="name" name="name" required placeholder="黃小慈">
                </div>
                <div class="input-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="tcweekly@gmail.com">
                </div>
                <div class="input-field">
                    <label for="phone">手機號碼</label>
                    <input type="text" id="phone" name="phone" pattern="09[0-9]{8}" required placeholder="0912582147">
                </div>
                <div class="input-field">
                    <label for="heXin">合心</label>
                    <select id="heXin" name="heXin" required>
                        <option value="" disabled selected>選擇合心</option>
                        <!-- 合心选项将由JavaScript动态填充 -->
                    </select>
                </div>
                <div class="input-field">
                    <label for="heQi">和氣</label>
                    <select id="heQi" name="heQi" required>
                        <option value="" disabled selected>選擇和氣</option>
                        <!-- 和氣选项将由JavaScript动态填充 -->
                    </select>
                </div>
                <button type="submit" class="btn">報到</button>
            </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // 加载合心数据
            fetch('community.json')
                .then(response => response.json())
                .then(data => {
                    var heXinSelect = $('#heXin');
                    data.forEach(function(heXin) {
                        heXinSelect.append($('<option>', {
                            value: heXin.title,
                            text: heXin.title
                        }));
                    });
                });

            // 当合心改变时，更新和氣的选项
            $('#heXin').change(function() {
                var selectedHeXinCode = $(this).val();
                var heQiSelect = $('#heQi');
                heQiSelect.empty().append($('<option>', {
                    value: '',
                    text: '選擇和氣',
                    disabled: true,
                    selected: true
                }));

                // 假设community.json中的数据结构是嵌套的，这里根据合心代码找到对应的和气数据
                fetch('community.json')
                    .then(response => response.json())
                    .then(data => {
                        var selectedHeXin = data.find(heXin => heXin.title === selectedHeXinCode);
                        if (selectedHeXin && selectedHeXin.child) {
                            selectedHeXin.child.forEach(function(heQi) {
                                heQiSelect.append($('<option>', {
                                    value: heQi.title,
                                    text: heQi.title
                                }));
                            });
                        }
                    });
            });

            // 处理表单提交
            $('#registrationForm').submit(function(event) {
                event.preventDefault();
                var formData = {
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        phone: $('#phone').val(),
                        heXin: $('#heXin').val(),
                        heQi: $('#heQi').val()
                    }
                };

                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        if (response.status === 'success') {
                            // 跳转到LINE群组链接
                            window.location.href = 'https://lin.ee/vkA5TWJ';
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
