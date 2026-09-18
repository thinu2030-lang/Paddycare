// ── Seeds (25 Districts × Multiple Varieties) ───────
        $seedData = [
            // Gampaha
            ['name'=>'BG 352','district'=>'Gampaha','season'=>'Both','maturity_days'=>105,'yield_per_ha'=>6.2,'blast_resistance'=>'High','description'=>'High yield variety, blast resistant, suitable for Gampaha wet zone.','is_recommended'=>true],
            ['name'=>'BG 358','district'=>'Gampaha','season'=>'Yala','maturity_days'=>110,'yield_per_ha'=>5.8,'blast_resistance'=>'Medium','description'=>'Flood tolerant variety for Yala season.','is_recommended'=>false],
            ['name'=>'BG 300','district'=>'Gampaha','season'=>'Maha','maturity_days'=>120,'yield_per_ha'=>5.5,'blast_resistance'=>'Medium','description'=>'Good for Maha season with high rainfall.','is_recommended'=>false],

            // Colombo
            ['name'=>'BG 359','district'=>'Colombo','season'=>'Both','maturity_days'=>108,'yield_per_ha'=>6.0,'blast_resistance'=>'High','description'=>'Suitable for low country wet zone, disease resistant.','is_recommended'=>true],
            ['name'=>'BG 250','district'=>'Colombo','season'=>'Yala','maturity_days'=>100,'yield_per_ha'=>5.2,'blast_resistance'=>'Medium','description'=>'Short duration variety for quick harvest.','is_recommended'=>false],

            // Kalutara
            ['name'=>'BG 352','district'=>'Kalutara','season'=>'Both','maturity_days'=>105,'yield_per_ha'=>6.1,'blast_resistance'=>'High','description'=>'Reliable variety for Kalutara wet zone conditions.','is_recommended'=>true],
            ['name'=>'BW 372','district'=>'Kalutara','season'=>'Maha','maturity_days'=>115,'yield_per_ha'=>5.6,'blast_resistance'=>'Medium','description'=>'Good performance in flood-prone low lands.','is_recommended'=>false],

            // Kandy
            ['name'=>'BG 94-1','district'=>'Kandy','season'=>'Both','maturity_days'=>112,'yield_per_ha'=>5.4,'blast_resistance'=>'High','description'=>'Mid country variety, adapted to cooler climate.','is_recommended'=>true],
            ['name'=>'AT 362','district'=>'Kandy','season'=>'Maha','maturity_days'=>125,'yield_per_ha'=>5.0,'blast_resistance'=>'Medium','description'=>'Suitable for upland paddy cultivation.','is_recommended'=>false],

            // Matale
            ['name'=>'BG 94-1','district'=>'Matale','season'=>'Both','maturity_days'=>112,'yield_per_ha'=>5.3,'blast_resistance'=>'High','description'=>'Performs well in mid country dry zone.','is_recommended'=>true],
            ['name'=>'BG 366','district'=>'Matale','season'=>'Yala','maturity_days'=>108,'yield_per_ha'=>5.1,'blast_resistance'=>'Medium','description'=>'Drought tolerant for Yala cultivation.','is_recommended'=>false],

            // Nuwara Eliya
            ['name'=>'Bg 379-2','district'=>'Nuwara Eliya','season'=>'Maha','maturity_days'=>130,'yield_per_ha'=>4.8,'blast_resistance'=>'Medium','description'=>'Cold tolerant variety for up country areas.','is_recommended'=>true],

            // Galle
            ['name'=>'BG 359','district'=>'Galle','season'=>'Both','maturity_days'=>108,'yield_per_ha'=>6.0,'blast_resistance'=>'High','description'=>'Excellent for southern wet zone conditions.','is_recommended'=>true],
            ['name'=>'BG 352','district'=>'Galle','season'=>'Yala','maturity_days'=>105,'yield_per_ha'=>5.9,'blast_resistance'=>'High','description'=>'High yield, blast resistant variety.','is_recommended'=>false],

            // Matara
            ['name'=>'BG 359','district'=>'Matara','season'=>'Both','maturity_days'=>108,'yield_per_ha'=>5.9,'blast_resistance'=>'High','description'=>'Reliable variety for southern coastal belt.','is_recommended'=>true],

            // Hambantota
            ['name'=>'AT 362','district'=>'Hambantota','season'=>'Maha','maturity_days'=>120,'yield_per_ha'=>5.3,'blast_resistance'=>'Medium','description'=>'Suited for dry zone, drought resistant.','is_recommended'=>true],
            ['name'=>'BG 300','district'=>'Hambantota','season'=>'Yala','maturity_days'=>118,'yield_per_ha'=>5.0,'blast_resistance'=>'Medium','description'=>'Good for irrigated dry zone farming.','is_recommended'=>false],

            // Jaffna
            ['name'=>'AT 362','district'=>'Jaffna','season'=>'Maha','maturity_days'=>122,'yield_per_ha'=>4.9,'blast_resistance'=>'Medium','description'=>'Adapted to northern dry zone conditions.','is_recommended'=>true],

            // Kurunegala
            ['name'=>'BG 366','district'=>'Kurunegala','season'=>'Both','maturity_days'=>108,'yield_per_ha'=>5.7,'blast_resistance'=>'High','description'=>'Popular variety for north western province.','is_recommended'=>true],
            ['name'=>'BG 300','district'=>'Kurunegala','season'=>'Yala','maturity_days'=>118,'yield_per_ha'=>5.4,'blast_resistance'=>'Medium','description'=>'Good drought tolerance for dry zone.','is_recommended'=>false],

            // Puttalam
            ['name'=>'AT 362','district'=>'Puttalam','season'=>'Maha','maturity_days'=>120,'yield_per_ha'=>5.1,'blast_resistance'=>'Medium','description'=>'Suitable for coastal dry zone areas.','is_recommended'=>true],

            // Anuradhapura
            ['name'=>'BG 300','district'=>'Anuradhapura','season'=>'Maha','maturity_days'=>120,'yield_per_ha'=>5.5,'blast_resistance'=>'Medium','description'=>'Widely grown in north central dry zone.','is_recommended'=>true],
            ['name'=>'AT 362','district'=>'Anuradhapura','season'=>'Yala','maturity_days'=>118,'yield_per_ha'=>5.2,'blast_resistance'=>'Medium','description'=>'Drought resistant for Yala cultivation.','is_recommended'=>false],

            // Polonnaruwa
            ['name'=>'BG 300','district'=>'Polonnaruwa','season'=>'Both','maturity_days'=>120,'yield_per_ha'=>5.6,'blast_resistance'=>'Medium','description'=>'Top variety for Polonnaruwa irrigation schemes.','is_recommended'=>true],

            // Badulla
            ['name'=>'Bg 379-2','district'=>'Badulla','season'=>'Maha','maturity_days'=>128,'yield_per_ha'=>4.9,'blast_resistance'=>'Medium','description'=>'Cold tolerant for Uva province highlands.','is_recommended'=>true],

            // Moneragala
            ['name'=>'AT 362','district'=>'Moneragala','season'=>'Maha','maturity_days'=>122,'yield_per_ha'=>5.0,'blast_resistance'=>'Medium','description'=>'Adapted to dry zone Uva conditions.','is_recommended'=>true],

            // Ratnapura
            ['name'=>'BG 94-1','district'=>'Ratnapura','season'=>'Both','maturity_days'=>112,'yield_per_ha'=>5.4,'blast_resistance'=>'High','description'=>'Good for wet zone Sabaragamuwa province.','is_recommended'=>true],

            // Kegalle
            ['name'=>'BG 94-1','district'=>'Kegalle','season'=>'Both','maturity_days'=>112,'yield_per_ha'=>5.3,'blast_resistance'=>'High','description'=>'Reliable for Kegalle mid-elevation areas.','is_recommended'=>true],

            // Trincomalee
            ['name'=>'AT 362','district'=>'Trincomalee','season'=>'Maha','maturity_days'=>120,'yield_per_ha'=>5.2,'blast_resistance'=>'Medium','description'=>'Suited to eastern dry zone climate.','is_recommended'=>true],

            // Batticaloa
            ['name'=>'BG 300','district'=>'Batticaloa','season'=>'Maha','maturity_days'=>118,'yield_per_ha'=>5.3,'blast_resistance'=>'Medium','description'=>'Good for eastern province irrigated lands.','is_recommended'=>true],

            // Ampara
            ['name'=>'BG 300','district'=>'Ampara','season'=>'Both','maturity_days'=>120,'yield_per_ha'=>5.7,'blast_resistance'=>'Medium','description'=>'Major rice growing district variety.','is_recommended'=>true],
            ['name'=>'AT 362','district'=>'Ampara','season'=>'Yala','maturity_days'=>116,'yield_per_ha'=>5.4,'blast_resistance'=>'Medium','description'=>'Reliable Yala season performance.','is_recommended'=>false],

            // Vavuniya
            ['name'=>'AT 362','district'=>'Vavuniya','season'=>'Maha','maturity_days'=>122,'yield_per_ha'=>5.0,'blast_resistance'=>'Medium','description'=>'Adapted to Vanni region dry climate.','is_recommended'=>true],

            // Mannar
            ['name'=>'AT 362','district'=>'Mannar','season'=>'Maha','maturity_days'=>122,'yield_per_ha'=>4.8,'blast_resistance'=>'Medium','description'=>'Suitable for northern coastal dry zone.','is_recommended'=>true],

            // Mullaitivu
            ['name'=>'AT 362','district'=>'Mullaitivu','season'=>'Maha','maturity_days'=>122,'yield_per_ha'=>4.9,'blast_resistance'=>'Medium','description'=>'Good for northern province conditions.','is_recommended'=>true],

            // Kilinochchi
            ['name'=>'AT 362','district'=>'Kilinochchi','season'=>'Maha','maturity_days'=>122,'yield_per_ha'=>4.9,'blast_resistance'=>'Medium','description'=>'Suited to northern dry zone farming.','is_recommended'=>true],
        ];

        foreach ($seedData as $s) {
            Seed::firstOrCreate(
                ['name' => $s['name'], 'district' => $s['district']],
                $s
            );
        }