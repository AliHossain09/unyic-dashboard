import img1 from "../../../assets/images/banner-carousel/mobile/banner1.jpg";
import img2 from "../../../assets/images/banner-carousel/mobile/banner2.jpg";
import img3 from "../../../assets/images/banner-carousel/mobile/banner3.jpg";
import img4 from "../../../assets/images/banner-carousel/mobile/banner5.jpg";
import img5 from "../../../assets/images/banner-carousel/mobile/banner6.jpg";
import img6 from "../../../assets/images/banner-carousel/mobile/banner7.jpg";
import Brands from "../Shared/Brands";
import FeaturedCollections from "../Shared/FeaturedCollections";
import FinestCollection from "../Shared/FinestCollection";
import NewArrivalsMobile from "./NewArrivalsMobile";
import PopularCategoriesMobile from "./PopularCategoriesMobile";

const imagesArray = [img1, img2, img3, img4, img5, img6];

const HomeMobile = () => {
  return (
    <>
      <PopularCategoriesMobile />
      <Carousel>
        {imagesArray?.map((image, index) => (
          <figure key={index}>
            <img
              src={image}
              alt={`Slide ${index + 1}`}
              className="w-full object-cover h-[400px] md:h-[800px]"
            />
          </figure>
        ))}
      </Carousel>

      <NewArrivalsMobile />
      <FeaturedCollections />
      <FinestCollection />
      <RecommendedCollectionMobile />
      <Brands />
    </>
  );
};

export default HomeMobile;
