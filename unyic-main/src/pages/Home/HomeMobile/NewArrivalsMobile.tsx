import { Link } from "react-router";
import newArrivalsData from "../../../data/newArrivalsData";

const NewArrivalsMobile = () => {
  return (
    <section className="text-dark-deep">
      <header className="ui-container text-center space-y-1 mb-8">
        <h3 className="text-2xl lg:text-3xl">New Arrivals</h3>
        <p>Discover Your Crafts</p>
      </header>

      <div className="ui-container !mt-0 flex gap-4 hide-scrollable">
        {newArrivalsData.map((category, index) => (
          <article key={index} className="space-y-2 text-center">
            <figure className="w-40 mx-auto">
              <Link to={category.link} title={category.title}>
                <img
                  src={category.imageSrc}
                  alt={category.title}
                  className="w-full h-full object-cover"
                />
              </Link>
              <figcaption className="font-semibold text-sm uppercase mt-2">
                {category.title}
              </figcaption>
            </figure>
          </article>
        ))}
      </div>
    </section>
  );
};

export default NewArrivalsMobile;
