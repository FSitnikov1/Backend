<!DOCTYPE html>

<head>
    <!-- Настройка viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Подключение css файла -->
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <!-- Название веб-страницы во вкладках -->
    <title>DATABASE_Form</title>
</head>

<body style="background-color: lightgray;">
    <div class="container-fluid container-md">
        <div class="row m-1 p-1 justify-content-center">
            <div class="col-sm-4">
                <div id="navbar">
                    <nav class="navbar navbar-dark bg-primary">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Form</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./logout.php" style="color: black;">Logout</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./login.php" style="color: black;">Loginin</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div id="messages" class="col m-1 p-1 rounded-3">
                    <?php
                    if (!empty($messages)) {
                        print('<div id="messages" class="container alert alert-danger" role="alert">');
                        foreach ($messages as $message) {
                            print($message);
                        }
                        print('</div>');
                    }
                    ?>
                </div>
                <div id="forma" class="col m-1 p-1 rounded-3 border border-dark d-flex justify-content-center text-center" style="background-color:darkgrey;">
                    <form class="formula col-10" action="" method="POST">
                        <h2 id="forma" class="undershape text-center">Форма</h2>
                        <div id="name" class="form_item input-group mb-3">
                            <span class="input-group-text">Name </span>
                            <input type="text" name="fio" class="form-control <?php if ($errors['fio']) print 'border border-danger'; ?>" placeholder="name" value="<?php if ($values['fio']) print $values['fio']; ?>">
                        </div>
                        <div id="email" class="form_item input-group mb-3">
                            <span class="input-group-text">E-mail </span>
                            <input type="email" name="email" class="form-control <?php if ($errors['email']) print 'border border-danger'; ?>" placeholder="email" value="<?php if ($values['email']) print $values['email']; ?>">
                        </div>
                        <div id="birthday" class="form_item input-group mb-3">
                            <span class="input-group-text">Birthday </span>
                            <input type="date" name="birthday" class="form-control <?php if ($errors['birthday']) print 'border border-danger'; ?>" value="<?php if ($values['birthday']) print $values['birthday']; ?>">
                        </div>
                        <div id="sex" class="form_check form_check-inline rounded-1 my-2" style="background-color:white;">
                            <span class=" input-group-text">Sex: </span>
                            <div class="form-check form-check-inline">
                                <input name="sex" class="form-check-input <?php if ($errors['sex']) print 'border border-danger'; ?>" type="radio" id="inlineRadio2" value=1 <?php if ($values['sex'] == '1') print 'checked="checked"'; ?>>
                                <label class="form-check-label" for="inlineRadio2">Women</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="sex" class="form-check-input <?php if ($errors['sex']) print 'border border-danger'; ?>" type="radio" id="inlineRadio3" value=2 <?php if ($values['sex'] == '2') print 'checked="checked"'; ?>>
                                <label class="form-check-label" for="inlineRadio3">Man</label>
                            </div>
                        </div>
                        <div id="limbs" class="form_check form_check-inline rounded-1 my-2" style="background-color:white;">
                            <span class="input-group-text">Number of limbs:</span>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="limbs" class="form-check-input <?php if ($errors['limbs']) print 'border border-danger'; ?>" value=1 <?php if ($values['limbs'] == 1) print 'checked="checked"'; ?>>
                                <label class="form-check-label" for="inlineRadio3">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="limbs" class="form-check-input <?php if ($errors['limbs']) print 'border border-danger'; ?>" value=2 <?php if ($values['limbs'] == 2) print 'checked="checked"'; ?>>
                                <label class="form-check-label" for="inlineRadio3">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="limbs" class="form-check-input <?php if ($errors['limbs']) print 'border border-danger'; ?>" value=3 <?php if ($values['limbs'] == 3) print 'checked="checked"'; ?>>
                                <label class="form-check-label" for="inlineRadio3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="limbs" class="form-check-input <?php if ($errors['limbs']) print 'border border-danger'; ?>" value=4 <?php if ($values['limbs'] == 4 or empty($values['limbs'])) print 'checked="checked"'; ?>>
                                <label class="form-check-label" for="inlineRadio3">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="limbs" class="form-check-input <?php if ($errors['limbs']) print 'border border-danger'; ?>" value=5 <?php if ($values['limbs'] == 5) print 'checked="checked"'; ?>>
                                <label class="form-check-label" for="inlineRadio3">5</label>
                            </div>
                        </div>
                        <div id="super" class="form_item" style="background-color:darkgrey;">
                            <span class="input-group-text">Superpowers: </span>
                            <label class="form_item input-group mb-3">
                                <select name="superpowers[]" class="form-select <?php if ($errors['superpowers']) print 'border border-danger'; ?>" multiple aria-label="multiple select example" size="3">
                                    <option value=1 <?php if (!empty($values['superpowers_imm']))  print 'selected="selected"'; ?>>Бессмертие</option>
                                    <option value=2 <?php if (!empty($values['superpowers_ptw']))   print 'selected="selected"'; ?>>Прохождение сквозь стены</option>
                                    <option value=3 <?php if (!empty($values['superpowers_lev']))   print 'selected="selected"'; ?>>Левитация</option>
                                </select>
                            </label>
                        </div>
                        <div id="bio" class="form_item">
                            <span class="input-group-text">Biography: </span>
                            <label class="form_item input-group mb-3">
                                <textarea name="biography" class="form-control <?php if ($errors['biography']) print 'border border-danger'; ?>" autofocus style="resize: vertical; min-height: 100px; max-height: 200px;"><?php print $values['biography']; ?></textarea>
                            </label>
                        </div>
                        <div id="checkbox" class="form_item form-check text-start <?php if ($errors['check']) print 'border border-danger'; ?>">
                            <input type="checkbox" name="check" class="form-check-input" value=1 <?php if ($values['check']) print 'checked="checked"'; ?>>
                            <label class="form-check-label"> с контрактом ознакомлен(а)</label>
                        </div>
                        <div id="btn" class="form_item btn">
                            <button class="btn btn-primary" type="submit">«Отправить»</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>