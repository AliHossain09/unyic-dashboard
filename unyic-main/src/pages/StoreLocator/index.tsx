import { useState, useMemo } from "react";
import { Link } from "react-router";
import StoreList from "./components/StoreList";
import StoreFilters from "./components/StoreFilters";
import { states, stores } from "./data";

const StoreLocator = () => {
  const [selectedState, setSelectedState] = useState("All");
  const [selectedCity, setSelectedCity] = useState<string | null>(null);

  // Available cities based on selected state
  const availableCities = useMemo(() => {
    if (selectedState === "All") {
      return [];
    }

    const stateData = states.find((state) => state.name === selectedState);
    return stateData?.city || [];
  }, [selectedState]);

  // Filter stores based on state and city
  const filteredStores = useMemo(() => {
    if (selectedState === "All") {
      return stores;
    }

    return stores.filter(({ city, state }) =>
      selectedCity === null
        ? state === selectedState
        : state === selectedState && city === selectedCity
    );
  }, [selectedState, selectedCity]);

  return (
    <main className="ui-container !mt-2 lg:!mt-6">
      {/* Breadcrumb */}
      <div className="mb-6 text-sm">
        <ul className="flex gap-2 divide-dark text-dark">
          <li>
            <Link to="/">Home</Link>
          </li>
          |
          <li className="text-dark-deep">
            <Link to="/">Store Locator</Link>
          </li>
        </ul>
      </div>

      <section>
        <h3 className="uppercase text-lg font-semibold mb-4">Find a Store</h3>

        <StoreFilters
          selectedState={selectedState}
          selectedCity={selectedCity}
          onStateChange={(state) => {
            setSelectedState(state);
            setSelectedCity(null); // Reset city
          }}
          onCityChange={setSelectedCity}
          availableCities={availableCities}
        />

        <hr className="my-8" />

        <StoreList stores={filteredStores} />
      </section>
    </main>
  );
};

export default StoreLocator;
