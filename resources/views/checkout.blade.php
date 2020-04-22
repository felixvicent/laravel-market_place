@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    
    <div class="container">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-8">
                    <h2>Dados de pagamento</h2>
                    <hr>
                </div>
            </div>
            <form action="" method="POST">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="card_number">Nome no cartão</label>
                            <input type="text" name="card_name" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="card_number">Número do cartão <span class="brand"></span></label>
                            <input type="text" name="card_number" class="form-control">
                            <input type="hidden" name="card_brand">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="card_month">Mês de vencimento</label>
                                <input type="number" min="1" max="12" value="1" name="card_month" class="form-control">
                            </div>
                        </div>  
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="card_year">Ano de vencimento</label>
                                @php
                                    $year = date("Y");
                                @endphp
                                <input type="number" min="{{ $year }}" value="{{ $year }}" name="card_year" class="form-control">
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="card_cvv">Número de segurança</label>
                            <input type="text" name="card_cvv" class="form-control">
                        </div>

                        <div class="col-md-12 installments form-group">

                        </div>
                    </div>

                    <button class="btn btn-lg btn-success processCheckout">Efetuar pagamento</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        const sessionId = '{{ session()->get('pagseguro_session_code') }}'
        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>

    <script>
        let amountTransaction = {{ $total }};
        let cardNumber = document.querySelector('input[name=card_number]');
        let spanBrand = document.querySelector('span.brand');

        cardNumber.addEventListener('keyup', function(){
            if(cardNumber.value.length >= 6){
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.value.substr(0, 6),
                    success: function(res){
                        let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png"/>`
                        spanBrand.innerHTML = imgFlag;
                        document.querySelector('input[name=card_brand]').value = res.brand.name;
                        getInstallments(amountTransaction, res.brand.name);
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
            }
        });

        let submitButton = document.querySelector('button.processCheckout');
        submitButton.addEventListener('click', function(event){
            event.preventDefault();

            PagSeguroDirectPayment.createCardToken({
                cardNumber: document.querySelector('input[name=card_number]').value,
                brand: document.querySelector('input[name=card_brand]').value,
                cvv: document.querySelector('input[name=card_cvv]').value,
                expirationMonth: document.querySelector('input[name=card_month]').value,
                expirationYear: document.querySelector('input[name=card_year]').value,
                success: function(res){
                    console.log(res);
                    proccessPayment(res.card.token);
                },
                error: function(err){
                    console.log(err);
                }
            });
        });

        function proccessPayment(token){
            let data = {
                card_token: token,
                hash: PagSeguroDirectPayment.getSenderHash(),
                installment: document.querySelector('select.select_installments').value,
                card_name: document.querySelector('input[name=card_name]').value,
                _token: '{{csrf_token()}}'
            };

            console.log(data);

            $.ajax({
                type: 'POST',
                url: '{{route("checkout.proccess")}}',
                data: data,
                dataType: 'json',
                success: function(res){
                    toastr.success(res.data.message, 'Sucesso');
                    window.location.href = '{{ route('checkout.thanks') }}?order=' + res.data.order;
                },
                error: function(err){
                    console.log(err);
                }   
            });

        }

        function getInstallments(amount, brand){
            PagSeguroDirectPayment.getInstallments({
                amount: amount,
                brand: brand,
                maxInstallmentNoInterest: 0,
                success: function(res){
                    let selectInstallments = drawSelectInstallments(res.installments[brand]);
                    document.querySelector('div.installments').innerHTML = selectInstallments;
                },
                error: function(err){
                    console.log(err);
                }
            });
        }

        function drawSelectInstallments(installments) {
            let select = '<label>Opções de Parcelamento:</label>';
            select += '<select class="form-control select_installments">';

            for(let l of installments) {
                select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity} x de R$ ${l.installmentAmount.toFixed(2)} - Total: R$ ${l.totalAmount.toFixed(2)}</option>`;
            }

            select += '</select>';

            return select;
	    }
    </script>
@endsection