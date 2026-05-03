import { useGetFeaturedCollectionsQuery } from "../../../store/features/collection/featuredCollectionsApi";
import FeaturedCollectionCard from "./FeaturedCollectionCard";

const FeaturedCollection = () => {
  const { data: collections, error } = useGetFeaturedCollectionsQuery();

  if (error) {
    console.warn("Error fetching featured collection: ", error);
  }

  if (!collections || collections.length === 0) {
    return null;
  }

  return (
    <section className="ui-container mt-responsive">
      <h3 className="mb-8 text-3xl lg:text-4xl font-medium text-center">
        Featured Collection
      </h3>

      <div className="grid grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-8 lg:gap-x-8">
        {collections.map((collection) => (
          <FeaturedCollectionCard key={collection.id} collection={collection} />
        ))}
      </div>
    </section>
  );
};

export default FeaturedCollection;
