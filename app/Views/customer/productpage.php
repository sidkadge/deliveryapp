<?php include __DIR__.'/../customer/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <!-- Product Grid -->
            <div class="product-grid">
                <?php foreach ($products as $product): 
                    $imagePath = 'public/Imges/' . $product->image;
                    $defaultImagePath = 'public/Imges/default.png';
                    if (!file_exists($imagePath)) {
                        $imagePath = $defaultImagePath;
                    }
                ?>
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo base_url($imagePath); ?>" alt="<?php echo $product->productname; ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product->productname; ?></h5>
                      
                        <div class="price-size">
                            <p>Price: <?php echo $product->price; ?></p>
                            <p>Size: <?php echo $product->Size . ' ' . $product->unit; ?></p>
                        </div>

                        <div class="add-to-cart-container">
                            <a href="<?=base_url(); ?>add_to_card/<?=$product->id; ?>"
                                class="btn btn-primary">Purchase</a>
                            <a href="<?=base_url(); ?>add_to_cardfors/<?=$product->id; ?>"
                                class="btn btn-secondary">Subscription</a>
                        </div>

                    </div>

                </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__.'/../customer/footer.php'; ?>

<style>
.product-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px;
}

.card {
    flex: 1 1 calc(25% - 20px);
    box-sizing: border-box;
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    max-width: 250px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-image {
    height: 200px;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-body {
    padding: 15px;
    text-align: center;
}

.card-title {
    font-size: 1.1em;
    font-weight: bold;
    margin-bottom: 10px;
}

.price-size {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.price-size p {
    margin: 0;
}

.add-to-cart-container {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 15px;
}

.add-to-cart-container a {
    flex: 1;
    text-align: center;
    padding: 10px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    transition: background-color 0.3s;
}

.add-to-cart-container a.btn-primary {
    background-color: #007bff;
}

.add-to-cart-container a.btn-primary:hover {
    background-color: #0056b3;
}

.add-to-cart-container a.btn-secondary {
    background-color: #28a745;
}

.add-to-cart-container a.btn-secondary:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .card {
        flex: 1 1 calc(33.33% - 20px);
    }
}

@media (max-width: 768px) {
    .card {
        flex: 1 1 calc(50% - 20px);
    }
}

@media (max-width: 480px) {
    .card {
        flex: 1 1 calc(100% - 20px);
    }
}
</style>
