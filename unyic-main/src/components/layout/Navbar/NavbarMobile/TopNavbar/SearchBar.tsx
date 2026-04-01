import { useState } from "react";
import { MdOutlineSearch } from "react-icons/md";

const SearchBar = () => {
  const [isVisible, setIsVisible] = useState(false);

  const toggleSearchBar = () => {
    setIsVisible((prev) => !prev);
  };

  return (
    <>
      <button onClick={toggleSearchBar}>
        <MdOutlineSearch className="text-2xl" />
      </button>

      {isVisible && (
        <div className="px-2 py-3 absolute left-0 right-0 top-full border bg-light text-base">
          <div className="flex items-center gap-2 p-2 border shadow relative">
            <MdOutlineSearch className="text-xl" />
            <input
              type="text"
              placeholder="Search India's most beautiful products"
              className="w-full focus:outline-none bg-transparent"
            />
            {/* Triangle pointer for search */}
            <span className="w-3 h-3 bg-light border border-e-0 border-b-0 absolute right-20  -top-5 z-10 rotate-45"></span>
          </div>
        </div>
      )}
    </>
  );
};

export default SearchBar;
