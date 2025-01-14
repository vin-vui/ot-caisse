<x-app-layout>
    <form method="POST" action="{{ route('addtocart') }}" id="addToCartForm">
        @csrf
        <div class="max-w-none mx-auto gap-4 space-y-1 font-paragraph">
            @foreach ($categories as $category)
                <div class="flex flex-col md:flex-row items-center p-2 gap-4" style="background-color: {{ $category->color }}">
                    <div class="font-semibold text-xl">
                        {{ $category->name }}
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($category->articles as $article)
                            @if ($article->status != 'inactif')
                                <label
                                    class="bg-white rounded-md shadow-xl hover:shadow flex items-center justify-between p-2 transition-all duration-300 hover:scale-95">
                                    <input type="checkbox" class='rounded-xl border-2' name="selected_articles[]"
                                        value="{{ $article->id }}">
                                        <div class="">
                                            <img class="h-24 w-24 object-cover {{ $article->status == 'actif' ? '' : 'grayscale' }}"
                                                 src="{{ $article->image != null ? url('..app/public/img' . $article->image) : url('..app/public/img/andrew-small-unsplash.jpg') }}"
                                                 alt="">
                                        </div>
                                    <div class="flex flex-col gap-1 items-center justify-center text-center">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-sm">{{ $article->title }}</span>
                                        </div>
                                        <div class="text-sm -mb-1">
                                            {{ $article->price }} €
                                        </div>
                                    </div>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-8 mflex items-center">
            <button type="submit" class="font-match border-2 border-emerald-300 text-black  rounded-md hover:bg-emerald-300 p-2">
                Valider la sélection
            </button>
        </div>
    </form>

    <script>
         document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('addToCartForm');
            form.addEventListener('submit', function(event) {
                if(!validateFormData()){
                    showNotification("Veuillez sélectionner au moins un produit.")
                    event.preventDefault();
                }
            });
        });

        function validateFormData() {
            // Sélectionne toutes les checkboxes des options de paiement
            var paymentCheckboxes = document.querySelectorAll('input[name="selected_articles[]"]');
            var isAnyPaymentMethodChecked = Array.from(paymentCheckboxes).some(checkbox => checkbox.checked);

            if (!isAnyPaymentMethodChecked) {
                // Aucune checkbox de paiement n'est cochée
              //  alert('Veuillez sélectionner une méthode de paiement.');
                return false; // Validation échoue
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

            // Ajoute la notification au document
            document.body.appendChild(notification);

            // Anime pour faire entrer la notification
            setTimeout(() => {
                notification.style.right = '20px';
            }, 100);

            // Supprime la notification après 5 secondes avec une animation de sortie
            setTimeout(function() {
                notification.style.right = '-400px'; // Anime pour sortir de l'écran
                // Attend la fin de l'animation pour supprimer l'élément
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 600); // Doit correspondre à la durée de l'animation
            }, 3000);
        }
    </script>
</x-app-layout>
