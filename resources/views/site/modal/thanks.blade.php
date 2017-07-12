<div data-id="modal-thanks" class="modal">
    <div class="thanks">
        <div class="header">
            <div class="close"></div>
            <div class="title1">Спасибо</div>
            <div class="title2">Ваш заказ принят</div>
        </div>
        <div class="main">
            <div class="left">
                Начислено на бонусный счет:
            </div>
            <div class="right">
                <span data-id="bonus-price-left" class="bonus-left">300</span>.<span data-id="bonus-price-right" class="bonus-left">00</span>
            </div>
        </div>
        <div class="footer">
            <div class="left">
                <a href="{{ getenv('LINK_INSTAGRAM') }}">
                    <div style="background-color: black; background-image: url('{{ asset('images/ad/instagram.png') }}');
                        width: 47px; height: 47px; background-size: 100% 100%;"></div>
                </a>
                <a href="{{ getenv('LINK_VK') }}">
                    <div style="background-color: black; background-image: url('{{ asset('images/ad/vk.png') }}');
                            width: 47px; height: 47px; background-size: 100% 100%;"></div>
                </a>
                <a href="{{ getenv('LINK_FACEBOOK') }}">
                    <div style="background-color: black; background-image: url('{{ asset('images/ad/facebook.png') }}');
                            width: 47px; height: 47px; background-size: 100% 100%;"></div>
                </a>
            </div>
            <div class="right">
                <span>Узнавайте</span>
                <span>Новости</span>
            </div>
            <div class="bottom">
                <span>Оставляй отзывы делись впечатлениями</span>
            </div>
        </div>
    </div>
</div>