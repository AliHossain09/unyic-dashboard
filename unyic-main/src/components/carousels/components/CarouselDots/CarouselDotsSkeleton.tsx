const CarouselDotsSkeleton = () => {
  return (
    <div className="mt-3 sm:mt-4 flex justify-center items-center">
      {[...Array(4)].map((_, index) => (
        <button key={index} className="p-[6px]">
          <span className={"block size-[9px] rotate-45 border-2"} />
        </button>
      ))}
    </div>
  );
};

export default CarouselDotsSkeleton;
