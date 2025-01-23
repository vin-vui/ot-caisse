<x-app-layout>
    <div class="max-w-7xl mx-auto py-4 px-2 sm:px-8">
        <div class="bg-teal-600 text-white p-2 rounded-t-xl py-4 flex items-center justify-between">
            <span class="font-bold text-2xl font-lobster">Panier</span>
        </div>
        <div class="bg-white shadow-xl p-6 rounded-b-xl font-paragraph">
            <form method="POST" action="{{ route('updatecart') }}">
                @csrf
                <table class="w-full text-sm text-left">
                    <thead class="sm:text-sm uppercase border-b">
                        <tr class="px-4 py-3">
                            <th>Article</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selectedArticles as $article)
                            <tr class="">
                                <td>{{ $article->title }}</td>
                                <td class="">
                                    <input type="text" name="price_{{ $article->id }}" value="{{ session('cart')[$article->id]['price'] }}"
                                        class="w-20 price" data-article-id="{{ $article->id }}"
                                        onchange="updatePrice({{ $article->id }})"> €
                                </td>
                                <td class="">
                                    <input type="number" name="quantity_{{ $article->id }}" value="{{ session('cart')[$article->id]['quantity'] }}"
                                        class="w-16 quantity" data-article-id="{{ $article->id }}"
                                        onchange="updateTotal({{ $article->id }})">
                                </td>
                                <td class=" total_{{ $article->id }}">
                                    {{ session('cart')[$article->id]['price'] * session('cart')[$article->id]['quantity'] }} €
                                </td>
                                <td class="px-2 py-2 flex justify-center items-center">
                                    <form method="POST" action="{{ route('updatecart') }}">
                                        @csrf
                                        <input type="hidden" name="articleId" value="{{ $article->id }}">
                                        <input type="hidden" name="quantity" value="0">
                                        <button type="submit" class="border-red-400 text-center hover:text-white hover:bg-red-600 text-red-600 font-bold py-2 px-4">
                                            X
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <div name="options" class="flex items-start justify-between mt-12">
            <div>
                <a href="{{ route('dashboard') }}" class="border-2 rounded-md border-teal-600 bg-white hover:bg-teal-600 hover:text-white text-gray-800 p-3 px-5">
                    Ajouter d'autres articles
                </a>
            </div>
            <div class="bg-white shadow-xl rounded-b-xl font-paragraph">
                <form method="POST" action="{{ route('confirmPurchase') }}" id="confirmPurchaseForm">
                    @csrf
                    <div class="bg-red-600 text-white p-2 rounded-t-xl py-4 flex items-center justify-between">
                        <div class="text-xl font-bold text-white">Total de la commande</div>
                        <div id="total_price" class="text-xl bg-white py-1 px-2 rounded-md font-bold text-red-600">
                            <span id="price_value">{{ $selectedArticles->sum(function ($article) {return session('cart')[$article->id]['price'] * session('cart')[$article->id]['quantity'];}) }}</span> €
                        </div>
                    </div>
                    <div class="flex flex-col items-center px-6 py-12">
                        <span class="text-lg font-bold flex flex-wrap mb-4">Méthode(s) de paiement</span>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 rounded-md py-1 px-2 border cursor-pointer hover:bg-gray-100"><input type="checkbox" class='rounded-xl border-2' name="payment_method[]" value="cb"> Carte bancaire</label>
                            <label class="flex items-center gap-2 rounded-md py-1 px-2 border cursor-pointer hover:bg-gray-100"><input type="checkbox" class='rounded-xl border-2' name="payment_method[]" value="especes">Espèces</label>
                            <label class="flex items-center gap-2 rounded-md py-1 px-2 border cursor-pointer hover:bg-gray-100"><input type="checkbox" class='rounded-xl border-2' name="payment_method[]" value="chq">Chèque</label>
                        </div>
                        <div id="payment_options" class="flex flex-col md:flew-row justify-center items-center mt-6 gap-4 w-full">
                            <div id="cb_option" class="flex flex-col w-full hidden">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="amount_cb" class="flex items-center gap-2">
                                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M4 4.25A2.75 2.75 0 0 0 1.25 7v10A2.75 2.75 0 0 0 4 19.75h16A2.75 2.75 0 0 0 22.75 17V9.75H6a.75.75 0 0 1 0-1.5h16.75V7A2.75 2.75 0 0 0 20 4.25z" clip-rule="evenodd"/></svg>
                                        Montant CB
                                    </label>
                                    <input  type="text" name="amount_cb" id="amount_cb" class="w-1/2">
                                </div>
                                <input type="text" name="comment_cb" id="comment_cb" placeholder="Commentaire" class="w-full">
                            </div>
                            <div id="espece_option" class="flex flex-col w-full hidden">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="amount_especes" class="flex items-center gap-2">
                                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16"><g fill="currentColor"><path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8a4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0a5 5 0 0 1 10 0"/><path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207c0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158c0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522c0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569c0 .339-.257.571-.709.614v-1.195z"/><path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/><path d="M9.998 5.083L10 5a2 2 0 1 0-3.132 1.65a6 6 0 0 1 3.13-1.567"/></g></svg>
                                        Montant espèces
                                    </label>
                                    <input  type="text" name="amount_especes" id="amount_especes" class="w-1/2">
                                </div>
                                <input type="text" name="comment_especes" id="comment_especes" placeholder="Commentaire" class="w-full">
                            </div>
                            <div id="cheque_option" class="flex flex-col w-full hidden">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="amount_chq" class="flex items-center gap-2">
                                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m21.4 14.35l-6.35 6.35q-.15.15-.337.225t-.388.075H13.5q-.2 0-.35-.15T13 20.5v-.825q0-.2.075-.387t.225-.338l6.35-6.35zM2 17V7q0-.825.588-1.412T4 5h16q.825 0 1.413.588T22 7q0 .275-.3.638T21 8h-.175q-.4 0-.763.15t-.637.425l-3.85 3.85q-.275.275-.637.425t-.763.15H7q-.425 0-.712.288T6 14t.288.713T7 15h4.8q.35 0 .475.3t-.125.55l-2.575 2.575q-.275.275-.637.425t-.763.15H4q-.825 0-1.412-.587T2 17m5-6h4q.425 0 .713-.288T12 10t-.288-.712T11 9H7q-.425 0-.712.288T6 10t.288.713T7 11m15 2.75L20.25 12l.9-.9q.125-.125.275-.125t.275.125l1.2 1.2q.125.125.125.275t-.125.275z"/></svg>
                                        Montant chèque
                                    </label>
                                    <input  type="text" name="amount_chq" id="amount_chq" class="w-1/2">
                                </div>
                                <input type="text" name="comment_chq" id="comment_chq" placeholder="Commentaire" class="w-full">
                            </div>
                        </div>
                    </div>
                    <div name="centerit" class="flex justify-center bg-teal-600/20 py-4 px-4 rounded-b-xl">
                        <button id="confirmPurchaseBtn" type="submit" class="border-2 rounded-md border-teal-600 bg-white hover:bg-teal-600 hover:text-white text-gray-800 p-3 px-5">
                            Valider le panier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('confirmPurchaseForm');
            form.addEventListener('submit', function(event) {

                var paymentCheckboxes = document.querySelectorAll('input[name="payment_method[]"]');
                var isAnyPaymentMethodChecked = Array.from(paymentCheckboxes).some(checkbox => checkbox.checked);
                if(!isAnyPaymentMethodChecked){
                    showNotification("Veuillez sélectionner une méthode de paiement.")
                    event.preventDefault();
                    return;
                }

                const amount_cb = document.getElementById("amount_cb").value ? document.getElementById("amount_cb").value  : 0;
                const amount_especes = document.getElementById("amount_especes").value ? document.getElementById("amount_especes").value  : 0;
                const amount_chq = document.getElementById("amount_chq").value ? document.getElementById("amount_chq").value  : 0;
                const amount_total = parseFloat(amount_cb) + parseFloat(amount_chq) + parseFloat(amount_especes) ;
                if( amount_total !== parseFloat(calculateTotalSum()) ){
                    showNotification("Le montant des moyens de paiements doit être équivalent au montant de la commmande.")
                    event.preventDefault();
                    return;
                }
            });
        });

        function validateFormData() {
            // Sélectionne toutes les checkboxes des options de paiement
            var paymentCheckboxes = document.querySelectorAll('input[name="payment_method[]"]');
            var isAnyPaymentMethodChecked = Array.from(paymentCheckboxes).some(checkbox => checkbox.checked);

            if (!isAnyPaymentMethodChecked) {
                // Aucune checkbox de paiement n'est cochée
              //  alert('Veuillez sélectionner une méthode de paiement.');
                return false; // Validation échoue
            }

            // Vérification montant écrit avec total
            const amount_cb = parseFloat(getElementById("amount_cb").value);
            const amount_chq = parseFloat(getElementById("amount_chq").value);
            const amount_especes = parseFloat(getElementById("amount_especes").value);
            const amount_total = amount_cb + amount_chq + amount_especes;
            if( amount_total !== parseFloat(calculateTotalSum()) ){
                return false;
            }

            // Ajoutez ici d'autres validations si nécessaire

            return true; // Validation réussit
        }

        function showNotification(message, type='error') {
            // Créer un élément de notification
            var notification = document.createElement('div');
            notification.innerHTML = `<span>${message}</span>`;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '-400px'; // Commencer hors de l'écran
            notification.style.padding = '15px 30px';
            notification.style.color = 'white';
            notification.style.backgroundColor = type === 'error' ? '#D32F2F' : '#388E3C';
            notification.style.borderRadius = '4px';
            notification.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            notification.style.zIndex = '1000';
            notification.style.transition = 'right 0.5s ease-in-out';
            notification.style.fontFamily = 'Arial, sans-serif';
            notification.style.fontSize = '16px';
            notification.style.lineHeight = '1.4';
            notification.style.maxWidth = '300px';
            notification.style.boxSizing = 'border-box';

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.right = '20px';
            }, 100);

            setTimeout(function() {
                notification.style.right = '-400px';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 600);
            }, 3000);
        }

        function preventInput(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
                element.addEventListener('keydown', function(e) {
                    e.preventDefault();
                });
            }
        }

        function preventFloatInput(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
                element.addEventListener('keydown', function(e) {
                    if (!e.key.match(/[0-9.]|\Backspace|Delete|ArrowLeft|ArrowRight|Tab/) || (e.key === '.' && e.target.value.includes('.'))) {
                        e.preventDefault();
                    }
                });
            }
        }

        preventFloatInput('amount_cb');
        preventFloatInput('amount_chq');
        preventFloatInput('amount_especes');

        var checkboxes = document.querySelectorAll('input[name="payment_method[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (checkbox.value === 'cb') {
                    document.getElementById('cb_option').style.display = checkbox.checked ? 'block' : 'none';
                }
                if (checkbox.value === 'especes') {
                    document.getElementById('espece_option').style.display = checkbox.checked ? 'block' : 'none';
                }
                if (checkbox.value === 'chq') {
                    document.getElementById('cheque_option').style.display = checkbox.checked ? 'block' : 'none';
                }
            });
        });

        function updateCart(articleId, price, quantity) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/updatecart', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.send('articleId=' + articleId + '&quantity=' + quantity + '&price=' + price);
        }

        function updatePrice(articleId) {
            var priceInput = document.querySelector('input[name="price_' + articleId + '"]');
            var newPrice = priceInput.value;
            var totalElement = document.querySelector('.total_' + articleId);
            var quantity = document.querySelector('input[name="quantity_' + articleId + '"]').value;
            totalElement.textContent = quantity * newPrice + ' €';
            var totalPriceElement = document.getElementById('total_price');
            totalPriceElement.textContent = calculateTotalSum() + ' €';

            // Update the total payment options
            /*document.getElementById('amount_cb').value =  calculateTotalSum();
            document.getElementById('amount_especes').value =  calculateTotalSum();
            document.getElementById('amount_chq').value =  calculateTotalSum();*/

            // Update cart in Session
            updateCart(articleId, newPrice, quantity);
        }

        function updateTotal(articleId) {
            // Get the new quantity
            var newQuantity = document.querySelector('input[name="quantity_' + articleId + '"]').value;

            // Update the total of the article
            var totalElement = document.querySelector('.total_' + articleId);
            var price = document.querySelector('input[name="price_' + articleId + '"]').value;
            var quantity = document.querySelector('input[name="quantity_' + articleId + '"]').value;
            totalElement.textContent = quantity * price + ' €';

            // Update the total sum for all articles
            var totalPriceElement = document.getElementById('total_price');
            totalPriceElement.textContent = calculateTotalSum() + ' €';

            // Update the total payment options
            /*document.getElementById('amount_cb').value =  calculateTotalSum();
            document.getElementById('amount_especes').value =  calculateTotalSum();
            document.getElementById('amount_chq').value =  calculateTotalSum();*/

            // Update cart in Session
            updateCart(articleId, price, quantity);
        }

        function calculateTotalSum() {
            var totalSum = 0;
            var quantityInputs = document.querySelectorAll('.quantity');
            for (var i = 0; i < quantityInputs.length; i++) {
                var articleId = quantityInputs[i].getAttribute('data-article-id');
                var quantity = quantityInputs[i].value;
                var price = document.querySelector('input[name="price_' + articleId + '"]').value;
                totalSum += quantity * price;
            }
            return totalSum;
        }

        document.onreadystatechange = function() {
            var rows = document.querySelectorAll('table tbody tr');
            for (var i = 0; i < rows.length; i++) {
                var firstCol = rows[i].cells[0]; //first column
                updateTotal(firstCol.textContent)
            }
        }

        function removeFromCart(articleId) {
            var xhr = new XMLHttpRequest();
            xhr.open('DELETE', '/cart/remove/' + articleId, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.send();

            xhr.onload = function() {
                console.log('Status: ' + xhr.status);
                console.log('Response: ' + xhr.responseText);

                if (xhr.status === 200) {
                    // If the request was successful, reload the page to update the cart
                    location.reload();
                } else {
                    // If the request failed, display an error message
                    alert('Echec de la suppression de l\'article !');
                }
            };

        }

    </script>
</x-app-layout>
