<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <header class="bg-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between">
            <h2 class="font-h1 text-4xl font-bold text-teal-600 leading-tight">
                Ventes
            </h2>
            <div class="date-filters">
                <input type="text" id="startDate" class="date-input" placeholder="Date de début">
                <input type="text" id="endDate" class="date-input" placeholder="Date de fin">
                <button
                    class="border-2 rounded-md border-teal-600 bg-white text-black font-h1 font-bold p-2 hover:bg-teal-600 hover:text-white mt-4 sm:mt-0"
                    onclick="exportTableToExcel('sale_table')">
                    Exporter
                </button>
            </div>
        </div>
    </header>
    <div class="mx-auto px-2 sm:px-6">
        <div class="row mt-2 font-bold">
            <div class="italic pb-4 text-black font-bold">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>
            <div class="relative overflow-x-auto overflow-auto shadow-xl rounded-lg">
                <table class="w-full text-sm text-left" id="sale_table">
                    <thead class="sm:text-sm uppercase bg-teal-600 text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                &nbsp;
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                Article
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal text-center">
                                Quantité
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal text-center">
                                Prix
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal text-center">
                                Méthode de paiement
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal text-center">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal">
                                Commentaire
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-normal text-center">
                                Date de création
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sell)
                            <tr class="px-6 py-4 bg-white text-black rounded-md">
                                <td scope="row" class="px-6 py-4 flex items-center text-black">{{ $sell->id }}</td>
                                <td class="px-6 py-4">{{ $sell->article?->title ?? 'NA' }}</td>
                                <td class="px-6 py-4 text-black whitespace-nowrap text-center">
                                    <span class="bg-gray-50 py-0.5 px-1 rounded-full">{{ $sell->quantity }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">{{ $sell->price }}€</td>
                                <td class="px-6 py-4 text-center">
                                    @php $paymentMethods = 0; @endphp
                                    @foreach ($sell->payments as $payment)
                                    @if($paymentMethods > 0) + @endif <span class="bg-blue-50 py-0.5 px-1 rounded-full">{{ $payment->method }}</span>
                                    @php $paymentMethods++; @endphp
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($sell->status == 'active')
                                        <span class="text-white bg-green-600 py-0.5 px-2 text-xs rounded-full">Actif</span>
                                    @else
                                        <span class="text-white bg-red-600 py-0.5 px-2 text-xs rounded-full">Inactif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $sell->commentary }}</td>
                                <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($sell->created_at)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
    <script>
        function exportTableToExcel(tableId, filename = '') {
            /* Sélectionne le tableau HTML par son ID */
            var table = document.getElementById(tableId);
            var ws = XLSX.utils.table_to_sheet(table); // Convertit le tableau en feuille de travail

            /* Crée un nouveau classeur et y ajoute la feuille de travail */
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

            /* Génère le fichier XLSX et le télécharge */
            XLSX.writeFile(wb, filename ? filename : 'export.xlsx');
        }
        
        flatpickr("#startDate", {});
        flatpickr("#endDate", {});

        document.addEventListener('DOMContentLoaded', function () {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');

            function filterTable() {
                const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
                endDate && endDate.setHours(23, 59, 59, 999); // Inclure la fin de la journée

                document.querySelectorAll('#sale_table tbody tr').forEach(row => {
                    const dateText = row.cells[7].textContent; // Assurez-vous que c'est la bonne colonne pour la date
                    const rowDate = dateText ? new Date(dateText.split('/').reverse().join('-')) : null;

                    if (startDate && endDate) {
                        if (rowDate >= startDate && rowDate <= endDate) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                        row.style.display = '';
                    }
                });
            }

            startDateInput.addEventListener('change', filterTable);
            endDateInput.addEventListener('change', filterTable);
        });
    </script>

</x-app-layout>
