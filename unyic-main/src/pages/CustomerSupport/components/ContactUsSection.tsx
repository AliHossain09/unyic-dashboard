import { useState } from "react";
import DropdownSelector from "../../../components/ui/DropdownSelector";
import Button from "../../../components/ui/Button";

const queries = [
  "Where is my order?",
  "My order is shipped but the delivery partner hasn't contacted me yet?",
  "I want to return a product",
  "Amount got deducted but my order status is showing cancelled",
  "I haven’t received my refund",
  "Received incorrect product/size",
  "Received damaged product",
  "Received Incomplete order",
];

const ContactUsSection = () => {
  const [selectedQuery, setSelectedQuery] = useState("");

  // Function to handle selection
  const handleSelect = (query: string) => {
    setSelectedQuery(query);
    console.log("Selected:", query);
  };

  return (
    <>
      <h3 className="uppercase pb-4 mb-8 border-b-4 border-dark-deep text-xl font-semibold">
        Contact Us
      </h3>
      <h5 className="text-lg mb-4">What can we help with you today?</h5>
      <div className="flex flex-col lg:flex-row gap-12 text-dark">
        <div className="lg:w-60 space-y-6">
          <div className="space-y-1">
            <label htmlFor="orderId">Your Query</label>
            <DropdownSelector
              selected={selectedQuery}
              list={queries}
              onSelect={handleSelect}
              defaultText="Please select query"
            />
          </div>

          {selectedQuery && (
            <>
              <div className="flex flex-col gap-1">
                <label htmlFor="orderId">Your Order ID</label>
                <input
                  id="orderId"
                  type="text"
                  className="w-full border rounded py-1 px-2 bg-background-light hide-number-spinner"
                />
              </div>

              <div className="flex flex-col gap-1">
                <label htmlFor="mobile">Your Mobile Number</label>
                <input
                  id="mobile"
                  type="number"
                  className="w-full border rounded py-1 px-2 bg-background-light hide-number-spinner"
                />
              </div>
            </>
          )}

          <p className="mt-6 text-dark">
            Login to get help with your order ID or recent orders
          </p>

          <Button variant="dark">Login</Button>
        </div>

        <div className="lg:mt-5">
          <p>Reach out to us:</p>
          <p className="font-semibold">hello@unyic.com</p>
        </div>
      </div>
    </>
  );
};

export default ContactUsSection;
