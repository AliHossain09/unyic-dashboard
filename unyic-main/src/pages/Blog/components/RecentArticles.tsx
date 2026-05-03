import { Link } from "react-router";
import Blogs from "../data/blogsData";

const RecentArticles = () => {
  return (
    <div className="space-y-6">
      <h3 className="flex items-center gap-1">
        <span className="block w-3 h-3 bg-primary-dark rounded-full"></span>{" "}
        <span className="uppercase font-semibold">Recent Articles</span>
      </h3>

      <ul className="space-y-9">
        {Blogs?.map((blog) => (
          <li key={blog.id}>
            <Link to={``}>
              <img
                src={blog?.image}
                alt={blog?.title}
                className="w-full rounded-md"
              />

              <h5 className="text-lg mb-2 mt-1 text-dark">{blog?.title} </h5>

              <p className="uppercase text-dark text-sm">
                {blog?.published_date}
              </p>
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default RecentArticles;
