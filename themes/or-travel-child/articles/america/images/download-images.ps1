# Download all images for Charleston & Savannah article

$images = @(
    @{name="charleston_historic_district_1.jpg"; url="https://static.wixstatic.com/media/4e19df_56a35f9f9c9b45218c48ba68d3844e6d~mv2.jpg"},
    @{name="charleston_historic_district_2.jpg"; url="https://static.wixstatic.com/media/4e19df_a53db2bcbfb94c158e55c243862e1668~mv2.jpg"},
    @{name="savannah_historical_district_1.jpg"; url="https://static.wixstatic.com/media/4e19df_778f78416fbb4baeaf19ef0c48d07102~mv2.jpg"},
    @{name="savannah_historical_district_2.jpg"; url="https://static.wixstatic.com/media/4e19df_306fb32afe4d41cc8f6191b098c955fa~mv2.jpg"},
    @{name="savannah_historical_district_3.jpg"; url="https://static.wixstatic.com/media/4e19df_86015c9907944c1892c08143dc0e845a~mv2.jpg"},
    @{name="charleston_historic_district_3.jpg"; url="https://static.wixstatic.com/media/4e19df_a6502a2ae4b7412db9cdb4bb5648afa2~mv2.jpg"},
    @{name="carolina_bbq.jpg"; url="https://static.wixstatic.com/media/4e19df_06f1a931098047f1bd371983c2b36276~mv2.jpg"},
    @{name="poogans_chicken_waffle.jpg"; url="https://static.wixstatic.com/media/4e19df_12c09ae4721241c3ad82a1124c3ca05d~mv2.jpg"},
    @{name="savannah_historic_district_4.jpg"; url="https://static.wixstatic.com/media/4e19df_c45c7470de2f44de90970f3149eca1ad~mv2.jpg"},
    @{name="andrew_pinckney_inn.jpg"; url="https://static.wixstatic.com/media/4e19df_0bd2ed04ace74a14b796a82fa86d9992~mv2.jpg"},
    @{name="charleston_1.jpg"; url="https://static.wixstatic.com/media/4e19df_d83c15a0351c4cb88352088b9b2e2203~mv2.jpg"},
    @{name="savannah_1.jpg"; url="https://static.wixstatic.com/media/4e19df_92b0a8d005554df88c98222b0774f6b9~mv2.jpg"},
    @{name="charleston_2.jpg"; url="https://static.wixstatic.com/media/4e19df_2a89dd1441f34bbea8dd731e34fb161c~mv2.jpg"},
    @{name="charleston_3.jpg"; url="https://static.wixstatic.com/media/4e19df_e61e9040d5c448b3ad5e7377af0ffb08~mv2.jpg"},
    @{name="charleston_4.jpg"; url="https://static.wixstatic.com/media/4e19df_fc19189ceeab4fdfa748678a48d8f6cb~mv2.jpg"},
    @{name="charleston_5.jpg"; url="https://static.wixstatic.com/media/4e19df_dbbb0db932b04b0b9e64547eb5dbef5e~mv2.jpg"},
    @{name="charleston_waterfront.jpg"; url="https://static.wixstatic.com/media/4e19df_ffcc311cd2e6482782d85e08f15f4302~mv2.jpg"},
    @{name="rainbow_row.jpg"; url="https://static.wixstatic.com/media/4e19df_983e1ff4cb4541eaa58047d177ec49ed~mv2.jpg"},
    @{name="kaminskys_dessert_cafe.jpg"; url="https://static.wixstatic.com/media/4e19df_89866b103e6c4d5b8468eb3f61d25cc9~mv2.jpeg"},
    @{name="callies_hot_little_biscuit.jpg"; url="https://static.wixstatic.com/media/4e19df_384b58d4d3284f669083923b6610425d~mv2.jpg"},
    @{name="old_slave_mart.jpg"; url="https://static.wixstatic.com/media/4e19df_fa2c4712f2554fecb83e142fd6844541~mv2.jpg"},
    @{name="boone_hall_1.jpg"; url="https://static.wixstatic.com/media/4e19df_12d7309975ce4e699fcaf28b2397cc3c~mv2.jpg"},
    @{name="boone_hall_2.jpg"; url="https://static.wixstatic.com/media/4e19df_aa3c800bc26e4bd9a206f1b3f5c4b870~mv2.jpg"},
    @{name="emanuel_church.jpg"; url="https://static.wixstatic.com/media/4e19df_48f92e43d1a249aaa3d7e1a78e9bab5a~mv2.jpg"},
    @{name="savannah_2.jpg"; url="https://static.wixstatic.com/media/4e19df_640e77e2a0c842db990c91fa679ae278~mv2.jpg"},
    @{name="savannah_3.jpg"; url="https://static.wixstatic.com/media/4e19df_c0f5bb4053bd4efe82615b3318fdb8ab~mv2.jpg"},
    @{name="chippewa_square.jpg"; url="https://static.wixstatic.com/media/4e19df_5706ffe2ca374f329eae3749959542fc~mv2.jpg"},
    @{name="forrest_gump_bench.jpg"; url="https://static.wixstatic.com/media/4e19df_bf19c79465b7435c88c3e69f7b4d05ba~mv2.jpg"},
    @{name="savannah_square_1.jpg"; url="https://static.wixstatic.com/media/4e19df_cbcb7c96fe654426909feab0b674fd7d~mv2.jpg"},
    @{name="savannah_square_2.jpg"; url="https://static.wixstatic.com/media/4e19df_b23e87c3c49541d49c49122ba2c2f71a~mv2.jpg"},
    @{name="city_market.jpg"; url="https://static.wixstatic.com/media/4e19df_97a8a3cd0d664340af215a839eb16360~mv2.jpg"},
    @{name="vinnie_pizza.jpg"; url="https://static.wixstatic.com/media/4e19df_09a457e5f26b4482ba7e02866681d3a7~mv2.jpg"},
    @{name="cathedral_basilica.jpg"; url="https://static.wixstatic.com/media/4e19df_4852cacb8cf54f8d80cfc67f8049a15c~mv2.jpg"},
    @{name="savannah_city_hall.jpg"; url="https://static.wixstatic.com/media/4e19df_f7c344920320439d9a04356002cd3227~mv2.jpg"},
    @{name="savannah_waterfront.jpg"; url="https://static.wixstatic.com/media/4e19df_2d1e9b0d92594b928f31d3d78bc50392~mv2.jpg"},
    @{name="forsyth_park_1.jpg"; url="https://static.wixstatic.com/media/4e19df_27d085fe95194d888ab7dff1aec2112d~mv2.jpg"},
    @{name="civil_war_monument.jpg"; url="https://static.wixstatic.com/media/4e19df_36abbb5c86c44fedb121e93c2b7b9330~mv2.jpg"},
    @{name="charleston_6.jpg"; url="https://static.wixstatic.com/media/4e19df_f8c6c5d26921469a902b249f4dab3cd6~mv2.jpg"},
    @{name="forsyth_park_2.jpg"; url="https://static.wixstatic.com/media/4e19df_a71158afbcb147e7bb3b13435dc57cc7~mv2.jpg"}
)

$webClient = New-Object System.Net.WebClient

foreach ($img in $images) {
    Write-Host "Downloading $($img.name)..."
    try {
        # Extract just the media ID and basic parameters from the URL
        $baseUrl = $img.url -split '/v1/' | Select-Object -First 1
        # Add simple parameters for better quality
        $fullUrl = "$baseUrl/v1/fill/w_740,h_493,al_c,q_85/image.jpg"
        
        $webClient.DownloadFile($fullUrl, $img.name)
        Write-Host "Downloaded $($img.name) successfully" -ForegroundColor Green
    }
    catch {
        Write-Host "Failed to download $($img.name): $_" -ForegroundColor Red
        # Try with the original URL as fallback
        try {
            $webClient.DownloadFile($img.url, $img.name)
            Write-Host "Downloaded $($img.name) successfully (fallback)" -ForegroundColor Yellow
        }
        catch {
            Write-Host "Failed to download $($img.name) even with fallback" -ForegroundColor Red
        }
    }
}

$webClient.Dispose()
Write-Host "Download complete!" -ForegroundColor Cyan
