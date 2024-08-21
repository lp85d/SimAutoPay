<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Выбор сим-карт и баланс</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    h2 {
        text-align: center;
        color: #333;
        padding-top: 20px;
    }
    table {
        width: 60%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    th, td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    input[type="checkbox"] {
        transform: scale(1.2);
    }
    .button-container {
        text-align: center;
        margin-top: 20px;
    }
    .dropdown-btn {
        display: inline-block;
        margin-right: 10px;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 80px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }
    select, button {
        padding: 10px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #4CAF50;
        color: white;
    }
    .add-btn, .select-all-btn, .deselect-all-btn, .select-zero-balance-btn {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
    }
    .flex-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px auto;
        width: 60%;
    }
</style>
</head>
<body>
    <h2>Выберите сим-карты и их баланс:</h2>
    <table>
        <tr>
            <th>Номер телефона</th>
            <th>Баланс</th>
        </tr>
        <tr>
            <td><input type="checkbox" id="sim1" name="sim1" value="50"> <label for="sim1">+79123456789</label></td>
            <td id="balance1">₽50</td>
        </tr>
        <tr>
            <td><input type="checkbox" id="sim2" name="sim2" value="30"> <label for="sim2">+74234567890</label></td>
            <td id="balance2">₽30</td>
        </tr>
        <tr>
            <td><input type="checkbox" id="sim3" name="sim3" value="20"> <label for="sim3">+79876543210</label></td>
            <td id="balance3">₽20</td>
        </tr>
        <!-- Добавляем ещё 4 сим-карты с нулевым балансом -->
        <tr>
            <td><input type="checkbox" id="sim4" name="sim4" value="0"> <label for="sim4">+71112223344</label></td>
            <td id="balance4">₽0</td>
        </tr>
        <tr>
            <td><input type="checkbox" id="sim5" name="sim5" value="0"> <label for="sim5">+75556667788</label></td>
            <td id="balance5">₽0</td>
        </tr>
        <tr>
            <td><input type="checkbox" id="sim6" name="sim6" value="0"> <label for="sim6">+79998887766</label></td>
            <td id="balance6">₽0</td>
        </tr>
        <tr>
            <td><input type="checkbox" id="sim7" name="sim7" value="0"> <label for="sim7">+78889990011</label></td>
            <td id="balance7">₽0</td>
        </tr>
    </table>
    
    <div class="flex-container">
        <button class="select-zero-balance-btn" onclick="selectZeroBalance()">Выделить только те, у кого нулевой баланс</button>
        <button class="select-all-btn" onclick="selectAll()">Выделить все</button>
        <button class="deselect-all-btn" onclick="deselectAll()">Снять выделение</button>
        <button class="add-btn" onclick="addNewNumber()">Добавить новый номер +</button>
        <div class="dropdown-btn">
            <select id="amountSelect">
                <option value="5">₽5</option>
                <option value="10">₽10</option>
                <option value="20">₽20</option>
                <option value="50">₽50</option>
            </select>
        </div>
        <button class="top-up-btn" onclick="topUpBalance()">Пополнить</button>
    </div>
    
    <script>
        var simCounter = 7; // Начальный счетчик для сим-карт (учитываем уже добавленные)

        function topUpBalance() {
            var amount = parseInt(document.getElementById("amountSelect").value);
            var selectedSims = document.querySelectorAll('input[type="checkbox"]:checked');
            
            selectedSims.forEach(function(sim) {
                var balanceId = sim.id.replace("sim", "balance");
                var balanceCell = document.getElementById(balanceId);
                var currentBalance = parseInt(sim.value);
                var newBalance = currentBalance + amount;
                balanceCell.textContent = "₽" + newBalance;
                sim.value = newBalance; // обновляем значение в атрибуте value
            });
        }
        
        function addNewNumber() {
            var table = document.querySelector("table");
            simCounter++; // Увеличиваем счетчик сим-карт
            var newId = "sim" + simCounter; // Новый уникальный идентификатор
            
            var newRow = table.insertRow(table.rows.length); // Вставляем новую строку перед последней (перед кнопкой)
            var newCell1 = newRow.insertCell(0);
            var newCell2 = newRow.insertCell(1);
            
            // Создаем новый чекбокс с уникальным id и меткой
            var checkbox = document.createElement('input');
            checkbox.type = "checkbox";
            checkbox.id = newId;
            checkbox.name = newId;
            checkbox.value = "0";
            
            var label = document.createElement('label');
            label.htmlFor = newId;
            label.appendChild(document.createTextNode(generateRandomPhoneNumber()));
            
            newCell1.appendChild(checkbox);
            newCell1.appendChild(label);
            
            // Добавляем ячейку для баланса с начальным значением и уникальным id
            var balanceId = "balance" + simCounter;
            newCell2.id = balanceId;
            newCell2.textContent = '₽0';
        }
        
        function generateRandomPhoneNumber() {
            var randomNumber = Math.floor(Math.random() * 10000000000);
            return "+7" + randomNumber.toString().padStart(10, '0');
        }
        
        function selectAll() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
        }
        
        function deselectAll() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }
        
        function selectZeroBalance() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                var balanceCell = checkbox.parentNode.nextElementSibling;
                var balanceAmount = parseInt(balanceCell.textContent.replace('₽', ''));
                checkbox.checked = (balanceAmount === 0);
            });
        }
    </script>
</body>
</html>
