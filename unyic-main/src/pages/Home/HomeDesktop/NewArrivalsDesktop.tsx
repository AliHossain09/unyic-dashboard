import { Link } from "react-router";
import Carousel from "../../../components/carousels/Carousel1";
import newArrivalsData from "../../../data/newArrivalsData";

const NewArrivalsDesktop = () => {
  return (
    <section className="ui-container grid grid-cols-4 items-center gap-x-12">
      <header className="text-center space-y-1">
        <h3 className="text-2xl lg:text-3xl">New Arrivals</h3>
        <p>Discover Your Crafts</p>
      </header>

      <div className="col-span-3 overflow-hidden">
        <Carousel displayIndicators={false} slidesToShow={3} autoplay={false}>
          {newArrivalsData?.map((item, index) => (
            <Link to={item.link} key={index} className="block">
              <figure className="text-center">
                <img
                  src={item.imageSrc}
                  alt={item.title}
                  title={item.title}
                  className="w-[calc(100%-30px)] mx-auto h-full object-cover"
                />

                <figcaption className="font-semibold text-lg uppercase mt-6">
                  {item.title}
                </figcaption>
              </figure>
            </Link>
          ))}
        </Carousel>
      </div>
    </section>
  );
};

export default NewArrivalsDesktop;
