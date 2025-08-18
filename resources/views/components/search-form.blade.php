        <!-- Find a car form -->
        <section class="find-a-car">
            <div class="container">
                <form
                    action= "{{ route('car.search') }}"
                    method= "GET"
                    class="find-a-car-form card flex p-medium"
                >
                    <div class="find-a-car-inputs">
                        <div>
                            <x-select-maker />
                        </div>
                        <div>
                            <x-select-model />
                        </div>
                        <div>
                            <x-select-state />
                        </div>
                        <div>
                            <x-select-city />
                        </div>
                        <div>
                            <x-select-car-type />
                        </div>
                        <div>
                            <input type="number" placeholder="Year From" />
                        </div>
                        <div>
                            <input type="number" placeholder="Year To" />
                        </div>
                        <div>
                            <input type="number" placeholder="Price From" />
                        </div>
                        <div>
                            <input type="number" placeholder="Price To" />
                        </div>
                        <div>
                            <x-select-fuel-type />
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-find-a-car-reset">
                            Reset
                        </button>
                        <button class="btn btn-primary btn-find-a-car-submit">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </section>
        <!--/ Find a car form -->
