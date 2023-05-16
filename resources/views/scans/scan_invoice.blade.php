<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>
<body>

<!--
  This example requires updating your template:

  ```
  <html class="h-full">
  <body class="h-full">
  ```
-->
<div class="min-h-full">
    <nav class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <img class="block h-8 w-auto lg:hidden" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                        <img class="hidden h-8 w-auto lg:block" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                    </div>
                    <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                        <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                        <a href="/scan/1" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page">Order</a>
                        <a href="/scan/2" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page">Picking</a>
                        <a href="/scan/3" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page">Confirmation</a>
                        <a href="/scan/4" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page">Invoice</a>
                        <a href="/scan/5" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page">Loading</a>
                        <a href="/scan/6" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page">Security</a>
                        <a href="/scan/7" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page">POD</a>
                        <a href="/scan" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Exporter</a>


                    </div>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!--
                          Heroicon name: outline/bars-3

                          Menu open: "hidden", Menu closed: "block"
                        -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!--
                          Heroicon name: outline/x-mark

                          Menu open: "block", Menu closed: "hidden"
                        -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="space-y-1 pt-2 pb-3">
                <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800" -->
                <a href="#" class="bg-indigo-50 border-indigo-500 text-indigo-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium" aria-current="page">Scanner: <b>Invoice</b></a>

                <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Exporter</a>

            </div>
        </div>
    </nav>

    <div class="py-10">
        <header>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900">
                    Scanner
                </h1>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                </svg>
            </div>
        </header>
        <main>
            @if (session()->has('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">{{ session()->get('success') }}</span>
                </div>
            @endif
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="px-4 py-8 sm:px-0">
                    <div class="flex-col justify-center">
                        <p>
                        <h2>Scan Document into Invoicing Stage</h2>
                        </p>
                    </div>
                    <div class="h-96 flex justify-center rounded-lg border-4 border-gray-200">
                        <form method='POST' @keydown.enter.prevent="submitForm" method="POST" action="/scan">
                            @csrf
                            <div class="flex-col justify-center">
                                <label for="pn_number" class="text-center block text-sm font-medium text-gray-700">Scan Document</label>
                                <div class="flex mt-1">
                                    <input type="text" autofocus name="order_number" id="order_number"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                           placeholder="Scan Here">
                                </div>
                                <div class="mt-2 mb-2">
                                    <a id="add_invoice" href="#" class="btn button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Invoice</a>
                                </div>
                                <div id="invoices">
                                    <div class="flex mt-1">
                                        <input type="text" autofocus name="invoices[]"
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                               placeholder="Scan Invoices Here">
                                        <a href="#" class="invoice_remover bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="remove_invoice_nr(this)">Remove</a>
                                    </div>
                                </div>
                                <input type="hidden" name="station" value="4">
                                <button type="submit" class="btn button bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>
</div>


<script>
    $("#add_invoice").on("click", function() {
        add_invoice_nr();
    });
    $(".invoice_remover").on("click", function(event) {
        remove_invoice_nr(event);
    });
    function add_invoice_nr() {
        let html = '<div class="flex mt-1">';
        html += '<input type="text" autofocus name="invoices[]"';
        html += 'class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"';
        html += 'placeholder="Scan Invoices Here">';
        html += '<a href="#" class="invoice_remover bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</a>';
        html += '</div>';
        $("#invoices").append(html);
    }

    function remove_invoice_nr(div){
        let parentDiv = div.parentNode;
        console.log("Removing");
        console.log(parentDiv);
        parentDiv.remove();
    }

</script>
</body>
</html>
